import {
  Pagination,
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationLink,
  PaginationNext,
  PaginationPrevious,
} from "@/components/ui/pagination"


const PrimaryPagination = ({ delta = 2, numPages, active, setActive }) => {
  const pages = Array.from(Array(numPages).keys());
  const length = pages.length;
  const start = active - delta < 0 ?
      0
      : Math.min(active - delta, length - (delta *  2 + 1));
  const end = active + delta > length - 1
      ? length - 1
      : Math.max(delta * 2, active + delta);
  const show = pages.slice(start, end + 1);
  const previousDisabled = active === 0;
  const nextDisabled = active === length - 1;
  return (
    <Pagination>
      <PaginationContent>
      <PaginationItem>
        <PaginationPrevious disabled={previousDisabled} onClick={() => setActive(active - 1)} />
      </PaginationItem>
      { active > delta && <PaginationEllipsis disabled /> }
      {
        show.map((i) => (
          <PaginationItem key={i}>
            <PaginationLink active={i === active} onClick={() => setActive(i)}>{ i + 1 }</PaginationLink>
          </PaginationItem>
        ))
      }
      { active < length - delta - 1 &&  <PaginationEllipsis disabled /> }
      <PaginationItem>
        <PaginationNext disabled={nextDisabled} onClick={() => {
          console.log({ active, setActive });
          setActive(active + 1)
        }} />
      </PaginationItem>
      </PaginationContent>
    </Pagination>
  );
};

/**
 *
 * Usage :
 *   const [ activePage, setActivePage ] = useState(0);
 *   const pageSize = 50;
 *   const { Pagination, slice } = getPagination({activePage, items: transactions, pageSize, setActivePage});
 *   return (<Pagination />
 *   <div>
 *      {
 *        transations.slice({transaction, i}) => // render
 *      }
 *  </div>
 *   <Pagination />);
 */
export const getPagination = ({ activePage, items, pageSize, setActivePage }) => {
  const numPages = Math.ceil(items.length/pageSize);
  const startDisplay = pageSize * activePage;
  const Pagination = () => <PrimaryPagination numPages={numPages} active={activePage} setActive={setActivePage} />;
  const slice = (items) => items.slice(startDisplay, Math.min(startDisplay + pageSize, items.length));
  return {
    numPages,
    Pagination,
    slice,
    startDisplay
  }

}

export default PrimaryPagination;

