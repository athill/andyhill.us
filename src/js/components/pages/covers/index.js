import { useEffect, useState } from 'react';
import { Button, Card, Col, Row } from 'react-bootstrap';

const Covers = () => {
  const [covers, setCovers] = useState(null);
  const [ filter, setFilter ] = useState('');
  const [curated, setCurated] = useState(null);
  const defaultSort = { type: 'date', dir: 'asc', prevType: 'title' };
  const [ sort, setSort ] = useState(defaultSort);

  const handleSort = type => {
    if (type === sort.type) {
      setSort({ type, dir: sort.dir === 'asc' ? 'desc' : 'asc', prevType: sort.type })
    } else {
      setSort({ type, dir: 'asc', prevType: sort.type });
    }
  };
  const getStringForCompare = (string) => string.toUpperCase().replace(/[^\w]/g, '');
  const sortTitleAsc = (a, b) => getStringForCompare(a.snippet.title).localeCompare(getStringForCompare(b.snippet.title));
  useEffect(() => {
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
      const { items } = await response.json();
      setCovers(items);
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
      <p>I've been publishing covers for the past few years, which is fun. My playlist,
        <a href="https://youtube.com/playlist?list=PL48l16ugvQtB6vQbtSpnePBWNm2sCmypf"  target="_blank" rel="noreferrer">Mediocre Covers of Good Songs</a>, is available on YouTube.
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
              <a href="">
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
    </div>
  );
};

/*
    <iframe width="560" height="315"
      src="https://www.youtube.com/embed/videoseries?list=PL48l16ugvQtB6vQbtSpnePBWNm2sCmypf"
      title="Mediocre Covers of Good Songs"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen>

    </iframe>
*/

export default Covers;
