import { useEffect, useState } from 'react';
import { Button, Card, Col, Modal, Row } from 'react-bootstrap';
import { FontAwesomeIcon as Icon } from '@fortawesome/react-fontawesome';
import { faCaretDown, faCaretLeft, faCaretRight, faCaretUp } from '@fortawesome/free-solid-svg-icons';

import './food.scss';

const FoodModal = ({images, selected, setSelected, handleClose, webRoot}) => {
  if (selected === false) {
    return null;
  }
  const current = images[selected];
  const next = (selected + 1) % images.length;
  const previous = selected > 0 ? selected - 1 : images.length - 1;
  return (
    <Modal className="food-modal" show={!(selected === false)} onHide={handleClose} size="lg">
    <Modal.Header closeButton>
      <Modal.Title>{current.title}</Modal.Title>
    </Modal.Header>
    <Modal.Body style={{ display: 'flex'}}>
      <div className="navigation"><div onClick={e => setSelected(previous)}><Icon icon={faCaretLeft} /></div></div>
      <div><img src={`${webRoot}/${current.image}`} className="photo-embed" alt={current.title} /></div>
      <div className="navigation"><div onClick={e => setSelected(next)}><Icon icon={faCaretRight} /></div></div>
    </Modal.Body>
  </Modal>
  );
};

const Food = () => {
  const [food, setFood] = useState(null);
  const [ filter, setFilter ] = useState('');
  const [curated, setCurated] = useState(null);
  const defaultSort = { type: 'date', dir: 'asc', prevType: 'title' };
  const [ sort, setSort ] = useState(defaultSort);
  const [ selected, setSelected ] = useState(false);

  const handleSort = type => {
    if (type === sort.type) {
      setSort({ type, dir: sort.dir === 'asc' ? 'desc' : 'asc', prevType: sort.type })
    } else {
      setSort({ type, dir: 'asc', prevType: sort.type });
    }
  };
  const getStringForCompare = (string) => string.toUpperCase().replace(/[^\w]/g, '');
  useEffect(() => {
    const sortTitleAsc = (a, b) => getStringForCompare(a.title).localeCompare(getStringForCompare(b.title));
    let filtered = food ? [...food] : food;
    // handle filter
    if (filter) {
      const upperCaseFilter = filter.toUpperCase();
      filtered = food.filter(({ title }) => {
        return title.toUpperCase().includes(upperCaseFilter)
      });
    };
    // handle sort
    // sort type has changed
    if (sort.prevType !== sort.type) {
      // sort ascending, if type is date, this is the original order and no sorting is necessary
      if (sort.type === 'title') {
        filtered = filtered.sort(sortTitleAsc);
      }
    // type is same, toggle sort direction
    } else {
      filtered = curated.reverse();
    }
    setCurated(filtered ? [...filtered] : null);
  }, [food, filter, sort])
  useEffect(() => {
    const fetchData = async () => {
      const response = await fetch('/api/food');
      const result = await response.json();
      setFood(result);
    };
    fetchData();
  }, []);
  const webRoot = `/data/food/images`;
  const SortIcon = ({ type }) => {
    if (sort.type === type) {
      return sort.dir === 'asc' ? <Icon icon={faCaretUp} /> : <Icon icon={faCaretDown} />;
    }
    return null;
  };
  const latest = food && food[food.length - 1];
  return (
    <div>
      <h2>Covers</h2>
      <p>
        As mentioned on my <a href="/recipes">recipes page</a>, I like to cook, so here are some of my results. You can find most of the recipes on that page.
      </p>
      <Row>
        <Col style={{ textAlign: 'center', margin: '2em' }}>
          <h2>Latest</h2>
          { latest && <h3>{latest && latest.title}</h3>}
          { latest && <p><img src={`${webRoot}/${latest.image}`} className="photo-embed" alt={latest.title} /></p> }
          <p>{latest && new Date(latest.date).toLocaleDateString()}</p>
        </Col>
      </Row>
      <Row>
        <Col md={8}><strong>Filter: </strong><input onChange={e => setFilter(e.target.value)} /></Col>
        <Col>
          <Button onClick={() => handleSort('title')}>Sort title {<SortIcon type="title" />}</Button>
        </Col>
        <Col>
          <Button onClick={() => handleSort('date')}>Sort date {<SortIcon type="title" />} </Button>
        </Col>
      </Row>
      { curated && curated.length + ' results' }
      <Row className="food">
        {
          curated && curated.map((item, i) => (
            <Col  key={i} md={3}>
              <a href="" onClick={e => { e.preventDefault(); setSelected(i) }}>
              <Card className="cover">
                <Card.Header as="h6">{item.title}</Card.Header>
                <Card.Body>
                  <img src={`${webRoot}/${item.image}`} width="200" alt={'thumbnail of ' + item.title + ' video'} />
                  <p>{new Date(item.date).toLocaleDateString()}</p>
                </Card.Body>
              </Card>
              </a>
            </Col>
          ))
        }
      </Row>
      <FoodModal images={curated} setSelected={setSelected} webRoot={webRoot} selected={selected} handleClose={() => setSelected(false)} />
    </div>
  );
};

export default Food;
