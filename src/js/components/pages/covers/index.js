import { useEffect, useState } from 'react';
import { Button, Card, Col, Modal, Row } from 'react-bootstrap';

import { getPagination } from '../../../utils/PrimaryPagination';

import './covers.css';


const Embed = ({ videoId, title , ...atts}) => (
  <iframe {...atts}
  src={`https://www.youtube.com/embed/${videoId}`}
  title={title}
  frameBorder="0"
  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
  allowFullScreen>
</iframe>
);

const CoverModal = ({selected, handleClose}) => {
  if (!selected) {
    return 'loading ...';
  }
  return (
    <Modal className="covers-modal" show={!!selected} onHide={handleClose} size="lg">
    <Modal.Header closeButton>
      <Modal.Title>{selected.title}</Modal.Title>
    </Modal.Header>
    <Modal.Body>
      <Embed title={selected.title} videoId={selected.resourceId.videoId} className="video-embed" />
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

  const [ activePage, setActivePage ] = useState(0);
  const pageSize = 50;
  const { Pagination, slice } = getPagination({activePage, items: curated || [], pageSize, setActivePage});

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
  const latest = covers && covers[covers.length - 1];
  return (
    <div>
      <h2>Covers</h2>
      <p>I've been publishing covers for the past few years, which is fun. My
        playlist,&nbsp; <a href="https://youtube.com/playlist?list=PL48l16ugvQtB6vQbtSpnePBWNm2sCmypf"  target="_blank" rel="noreferrer">Mediocre Covers of Good Songs</a>, is available on YouTube.
      </p>
      <Row>
        <Col style={{ textAlign: 'center', margin: '2em' }}>
          <h2>Latest Video - {latest && latest.snippet.title}</h2>
          { latest && <Embed title={latest.snippet.title} videoId={latest.snippet.resourceId.videoId} className="video-embed" /> }
          <p>{latest && new Date(latest.snippet.publishedAt).toLocaleDateString()}</p>
        </Col>
      </Row>
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
      <Pagination />
      <Row className="covers">
        {
          curated && slice(curated).map(({ snippet }, i) => (
            <Col  key={i} md={3}>
              <a href="" onClick={e => { e.preventDefault(); setSelected(snippet) }}>
              <Card className="cover">
                <Card.Header as="h6">{snippet.title}</Card.Header>
                <Card.Body>
                  <img src={snippet.thumbnails.medium.url} width="200" alt={'still frame of ' + snippet.title + ' video'} />
                  <p>{new Date(snippet.publishedAt).toLocaleDateString()}</p>
                </Card.Body>
              </Card>
              </a>
            </Col>
          ))
        }
      </Row>
      <Pagination />
      <CoverModal selected={selected} handleClose={() => setSelected(false)} />
    </div>
  );
};

export default Covers;
