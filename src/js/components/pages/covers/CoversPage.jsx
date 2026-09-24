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
import { ClearableInput } from '@/components/clearable-input';
import { useSearchParams } from "react-router-dom";

import { getPagination } from '../../../utils/PrimaryPagination';

// import './covers.css';


const Embed = ({ videoId, title , ...atts}) => (
  <iframe className="w-62.5 h-40 sm:w-125 sm:h-78.75 inline" {...atts}
  src={`https://www.youtube.com/embed/${videoId}`}
  title={title}
  frameBorder="0"
  allow="picture-in-picture"
  allowFullScreen>
</iframe>
);

// allow: accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope;

const CoverModal = ({selected, handleClose}) => {
  return (
    <Dialog open={!!selected} onOpenChange={(open) => { if (!open) handleClose(); }}>
      <DialogContent>
        <DialogHeader>
          <DialogTitle>{selected?.title}</DialogTitle>
        </DialogHeader>
        <Embed title={selected?.title} videoId={selected?.resourceId?.videoId} />
      </DialogContent>
      </Dialog>
  );
};

const Covers = () => {
  const [searchParams, setSearchParams] = useSearchParams(location.search);
  console.log({searchParams});
  const [covers, setCovers] = useState([]);
  const [curated, setCurated] = useState(null);
  const defaultSort = { sort: searchParams.get('sort') || 'date', dir: searchParams.get('dir') || 'asc' };
  // const [ sort, setSort ] = useState(defaultSort);
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
    const { sort, dir } = Object.fromEntries(searchParams);
    let newDir = 'asc';
    if (type === sort) {
      newDir = dir === 'asc' ? 'desc' : 'asc';
    }
    setSearchParams({
      ...Object.fromEntries(searchParams),
      sort: type,
      dir: newDir,
      page: '0'
    });
  };
  const getStringForCompare = (string) => string.toUpperCase().replace(/[^\w]/g, '');
  const sortTitleAsc = (a, b) => getStringForCompare(a.snippet.title).localeCompare(getStringForCompare(b.snippet.title));
  const sortDateAsc = (a, b) => new Date(a.snippet.publishedAt) - new Date(b.snippet.publishedAt);
  useEffect(() => {

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
    if (searchParams.get('sort') === 'date') {
      filtered = filtered.sort(sortDateAsc);
    }
    if (searchParams.get('sort') === 'title') {
      filtered = filtered.sort(sortTitleAsc);
    }
    if (searchParams.get('dir') === 'desc') {
      filtered = filtered.reverse();
    }
    setCurated(filtered ? [...filtered] : null);
  }, [covers, searchParams])
  useEffect(() => {
    const fetchData = async () => {
      const response = await fetch('/api/youtube');
      const result = await response.json();
      setCovers(result);
    };
    fetchData();
  }, []);
  const sortIcon = type => {
    if (searchParams.get('sort') === type) {
      return searchParams.get('dir') === 'asc' ? '^' : 'v';
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
        { latest && <Embed title={latest.snippet.title} videoId={latest.snippet.resourceId.videoId} /> }
        <p>{latest && new Date(latest.snippet.publishedAt).toLocaleDateString()}</p>
      </div>
      <div className="flex w-full justify-between">
        <div className="w-1/2">
          <ClearableInput
            setValue={value => setSearchParams({
              ...Object.fromEntries(searchParams),
              filter: value
            })}
            placeholder="Filter..."
            value={searchParams.get('filter') || ''}
          />
        </div>
        <div>
          <Button onClick={() => handleSort('title')}>Sort title {sortIcon('title')}</Button>
          <Button onClick={() => handleSort('date')}>Sort date {sortIcon('date')} </Button>
        </div>
      </div>
      <div className="flex w-full justify-between">
        <div>
          <Pagination />
        </div>
        { curated && <div>{curated.length}&nbsp;results</div> }
      </div>
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

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
