import { toHaveErrorMessage } from '@testing-library/jest-dom/dist/matchers';
import { useEffect, useState } from 'react';
import { Button, Card, Col, Row } from 'react-bootstrap';

const Covers = () => {
  const [covers, setCovers] = useState(null);
  const [ filter, setFilter ] = useState('');
  const [curated, setCurated] = useState(null);
  const defaultSort = { type: 'date', dir: 'asc', prevType: 'alpha' };
  const [ sort, setSort ] = useState(defaultSort);

  const handleSort = type => {
    if (type === sort.type) {
      setSort({ type, dir: sort.dir === 'asc' ? 'desc' : 'asc', prevType: sort.type })
    } else {
      setSort({ type, dir: 'asc', prevType: sort.type });
    }
  };

  useEffect(() => {
    let filtered = covers;
    if (filter) {
      const upperCaseFilter = filter.toUpperCase();
      filtered = covers.filter(({ snippet }) => {
        return snippet.title.toUpperCase().includes(upperCaseFilter)
      });
    };
    const sortAlphaAsc = ({ snippet: snippetA }, { snippet: snippetB}) => snippetB.title.toUpperCase() - snippetA.title.toUpperCase();
    console.log(sort);
    if (sort.prevType !== sort.type) {
      console.log('type has changed')
      if (sort.type === 'alpha') {
        filtered = filtered.sort(sortAlphaAsc);
      }
    // type is same toggle sort direction
    } else {
      if (sort.type === 'date') {
        console.log('toggling date sort');
        if (sort.dir === 'desc') {
          console.log('date desc');
          filtered = filtered.reverse();
        }
      } else {
        console.log('toggling alpha sort');
        filtered = sort.dir === 'asc'
          ? filtered.sort(sortAlphaAsc)
          : filtered.sort(({ snippet: snippetA }, { snippet: snippetB}) => snippetA.title.toUpperCase() - snippetB.title.toUpperCase());
      }
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
  curated && console.log('curated: ' + curated[0].snippet.title)
  return (
    <div>
      <h2>Covers</h2>
      <p>I've been publishing covers for the past few years, which is fun. My playlist,
        <a href="https://youtube.com/playlist?list=PL48l16ugvQtB6vQbtSpnePBWNm2sCmypf"  target="_blank" rel="noreferrer">Mediocre Covers of Good Songs</a>, is available on YouTube.
      </p>
      <Row>
        <Col><strong>Filter: </strong><input onChange={e => setFilter(e.target.value)} /></Col>
        <Col>
          <Button onClick={() => handleSort('alpha')}>Sort alpha {sortIcon('alpha')}</Button>
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
