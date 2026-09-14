import { useEffect, useState } from 'react';
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog"
import { Input } from "@/components/ui/input"
import { useSearchParams } from "react-router-dom";

import { getPagination } from '../../../utils/PrimaryPagination';

// import './covers.css';


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
  return (
    <Dialog open={!!selected} onOpenChange={(open) => { if (!open) handleClose(); }}>
      <DialogContent>
        <DialogHeader>
          <DialogTitle>{selected?.title}</DialogTitle>
        </DialogHeader>
        <Embed title={selected?.title} videoId={selected?.resourceId?.videoId} className="video-embed" />
      </DialogContent>
      </Dialog>
  );
};

const Covers = () => {
  const [searchParams, setSearchParams] = useSearchParams(location.search);
  console.log({searchParams});
  const [covers, setCovers] = useState(null);
  const [curated, setCurated] = useState(null);
  const defaultSort = { type: 'date', dir: 'asc', prevType: 'title' };
  const [ sort, setSort ] = useState(defaultSort);
  const [ selected, setSelected ] = useState(null);
  const pageSize = 50;
  const { Pagination, slice } = getPagination({
    activePage: parseInt(searchParams.get('page') || '0', 10),
    items: curated || [],
    pageSize,
    setActivePage: (page) => {
      setSearchParams({
        ...Object.fromEntries(searchParams),
        page: page?.toString() || '0'
      })
    }
  });

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
    if (filtered) {
      const upperCaseFilter = searchParams.get('filter') ? searchParams.get('filter').toUpperCase() : '';
      filtered = filtered.filter(({ snippet }) => {
        return Object.keys(snippet.thumbnails).length && (!upperCaseFilter || snippet.title.toUpperCase().includes(upperCaseFilter));
      });
    }
    // handle sort
    // sort type has changed
    if (sort.prevType !== sort.type) {
      // sort ascending, if type is date, this is the original order and no sorting is necessary
      if (sort.type === 'title') {
        filtered = filtered.sort(sortTitleAsc);
      }
    // type is same, toggle sort direction
    } else {
      filtered = filtered.reverse();
    }
    setCurated(filtered ? [...filtered] : null);
  }, [covers, searchParams, sort])
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
      <div className="text-center my-8">
        <h2>Latest Video - {latest && latest.snippet.title}</h2>
        { latest && <Embed title={latest.snippet.title} videoId={latest.snippet.resourceId.videoId} className="video-embed" /> }
        <p>{latest && new Date(latest.snippet.publishedAt).toLocaleDateString()}</p>
      </div>
      <div className="grid grid-cols-12">
        <div className="col-span-8">
          <strong>Filter: </strong>
          <Input onChange={e => setSearchParams({
            ...Object.fromEntries(searchParams),
            filter: e.target.value })}
            defaultValue={searchParams.get('filter') || ''}
          />
        </div>
        <div className="col-span-2">
          <Button onClick={() => handleSort('title')}>Sort title {sortIcon('title')}</Button>
        </div>
        <div className="col-span-2">
          <Button onClick={() => handleSort('date')}>Sort date {sortIcon('date')} </Button>
        </div>
      </div>
      { curated && curated.length + ' results' }
      <Pagination />
      <div className="grid grid-cols-4 gap-4">

        {
          curated && slice(curated).map(({ snippet }, i) => (
            <div key={i} className="col-span-1">
                    <Card className="cover cursor-pointer" onClick={() => setSelected(snippet)}>
                      <CardHeader>
                        <CardTitle>{snippet.title}</CardTitle>
                      </CardHeader>
                      <CardContent>
                        <img src={snippet.thumbnails.medium.url} width="200" alt={'still frame of ' + snippet.title + ' video'} />
                        <p>{new Date(snippet.publishedAt).toLocaleDateString()}</p>
                      </CardContent>
                    </Card>
            </div>
          ))
        }
      </div>
      {/* <Pagination /> */}
      <CoverModal selected={selected} handleClose={() => setSelected(null)} />
    </div>
  );
};

export default Covers;
