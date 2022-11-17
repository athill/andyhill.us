import { useEffect, useState } from 'react';
import { Button, Card, Col, Modal, Row } from 'react-bootstrap';

const CoverModal = ({selected, handleClose}) => {
  if (!selected) {
    return 'loading ...';
  }
  const src = `https://www.youtube.com/embed/${selected.resourceId.videoId}`;
  return (
    <Modal className="covers-modal" show={!!selected} onHide={handleClose} size="lg">
    <Modal.Header closeButton>
      <Modal.Title>{selected.title}</Modal.Title>
    </Modal.Header>
    <Modal.Body>
      <iframe width="560" height="315"
        src={src}
        title={selected.title}
        frameBorder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowFullScreen>
      </iframe>
    </Modal.Body>
  </Modal>
  );
};

const Covers = () => {
  const [covers, setCovers] = useState(null);
  const [ filter, setFilter ] = useState('');
  const [curated, setCurated] = useState(null);
  const defaultSort = { type: 'date', dir: 'asc', prevType: 'title' };
  const [ sort, setSort ] = useState(defaultSort);
  const [ selected, setSelected ] = useState(null);

  const handleSort = type => {
    if (type === sort.type) {
      setSort({ type, dir: sort.dir === 'asc' ? 'desc' : 'asc', prevType: sort.type })
    } else {
      setSort({ type, dir: 'asc', prevType: sort.type });
    }
  };
  const getStringForCompare = (string) => string.toUpperCase().replace(/[^\w]/g, '');
  useEffect(() => {
    const sortTitleAsc = (a, b) => getStringForCompare(a.snippet.title).localeCompare(getStringForCompare(b.snippet.title));
    let filtered = covers ? [...covers] : covers;
    // handle filter
    if (filter) {
      const upperCaseFilter = filter.toUpperCase();
      filtered = covers.filter(({ snippet }) => {
        return snippet.title.toUpperCase().includes(upperCaseFilter)
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
  }, [covers, filter, sort])
  useEffect(() => {
    const fetchData = async () => {
      const response = await fetch('/api/youtube');
      const result = await response.json();
      setCovers(result);
    };
    fetchData();
  }, []);
  const sortIcon = type => {
    if (sort.type === type) {
      return sort.dir === 'asc' ? '^' : 'v';
    }
    return null;
  };
  return (
    <div>
      <h2>Covers</h2>
      <p>I've been publishing covers for the past few years, which is fun. My
        playlist,&nbsp; <a href="https://youtube.com/playlist?list=PL48l16ugvQtB6vQbtSpnePBWNm2sCmypf"  target="_blank" rel="noreferrer">Mediocre Covers of Good Songs</a>, is available on YouTube.
      </p>
      <Row>
        <Col md={8}><strong>Filter: </strong><input onChange={e => setFilter(e.target.value)} /></Col>
        <Col>
          <Button onClick={() => handleSort('title')}>Sort title {sortIcon('title')}</Button>
        </Col>
        <Col>
          <Button onClick={() => handleSort('date')}>Sort date {sortIcon('date')} </Button>
        </Col>
      </Row>
      { curated && curated.length + ' results' }
      <Row className="covers">
        {
          curated && curated.map(({ snippet }, i) => (
            <Col  key={i} md={3}>
              <a href="" onClick={e => { e.preventDefault(); setSelected(snippet) }}>
              <Card className="cover">
              <Card.Header as="h6">{snippet.title}</Card.Header>
              <Card.Body>
                <img src={snippet.thumbnails.medium.url} width="200" alt={'still frame of ' + snippet.title + ' video'} />
              </Card.Body>

              </Card>
              </a>
            </Col>
          ))
        }
      </Row>
      <CoverModal selected={selected} handleClose={() => setSelected(false)} />
    </div>
  );
};

export default Covers;
