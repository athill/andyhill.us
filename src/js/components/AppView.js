import React from 'react';
import { Col, Container, Row } from 'react-bootstrap';
import { Link, NavLink, Route, Routes } from 'react-router-dom';

// import history from '../history';
// import Blogs from './pages/Blogs';
import Covers from './pages/covers';
import Home from './pages/Home';
import NotFound from './NotFound';
// import Inspire from './pages/inspire';
// import News from './pages/news';
// import Portfolio from './pages/portfolio';
import Recipes from './pages/recipes';
import Resume from './pages/resume';

import './appview.css';

const navigation = [
  { display: 'Home', href: '/' },
  { display: 'Resume', href: '/resume/' },
  // { display: 'Portfolio', href: '/portfolio/' },
  { display: 'Recipes', href: '/recipes/' },
  { display: 'Covers', href: '/covers/' },
  // { display: 'News', href: '/news/', exact: false },
  // { display: 'Inspiration', href: '/inspire/', exact: false },
  // { display: 'Blogs', href: '/blogs/' },
];

const activeClassName = "active";

const Navigation = ({ onLinkClick }) => (
  <ul>
      {
          navigation.map(({ display, href}) => <li key={href}><NavLink
            className={({ isActive }) => isActive ? activeClassName : undefined }
                to={href}
                onClick={ onLinkClick }>{ display }</NavLink></li>)
      }
  </ul>
);

class MobileHeader extends React.Component {
  constructor(props) {
      super(props);

      this.state = { showNav: false };
      this._menuToggle = this._menuToggle.bind(this);
      this._menuClose = this._menuClose.bind(this);
  }

  _menuClose(e) {
      this.setState({
          showNav: false
      });
  }

  _menuToggle(e) {
  this.setState ({
          showNav: !this.state.showNav
      });
  }


  render() {
      return (
          <div className="mobile-header">
              <div className="mobile-navbar">
                  <h1 className="mobile-navbar-title"><Link to="/">andyhill.us</Link></h1>
                  <span className="button" onClick={this._menuToggle}><i className="fa fa-bars"></i></span>
              </div>
              { this.state.showNav && <Navigation onLinkClick={this._menuClose} /> }
          </div>
      )
  }
}

const headerImages = [
  { src: 'house.jpg' },
  { src: 'band.jpg' },
  { src: 'showwater.jpg' },
  { src: 'wfhb.jpg' },
];

const Header = () => (
  <div className="app-header">
      <div className="desktop-header">
          <div className="img-container">
              {
                  headerImages.map(({ src }) => <img key={ src } src={"/images/header/" + src} alt="" className="header-img"  />)
              }
              <h1 className="page-title">andyhill.us</h1>
          </div>

          <nav id="nav" role="navigation">
              <Navigation />
          </nav>
      </div>
  </div>
);

const AppView = () => (
  <div className="app">
    <Container>
    <Row className="wrapper">
      <Col md={1} className="site-side-padding"></Col>
        <MobileHeader />
        <Col md={10} xs={12} id="app-container">
          <Header />
            <main id="main">
              <Routes>
                <Route path="/" element={<Home />}/>
                <Route path="resume" element={<Resume />}/>
                {/* <Route path="/portfolio" component={Portfolio}/> */}
                <Route path="/recipes" element={<Recipes />}/>
                <Route path="/covers" element={<Covers />}/>
                {/* <Route path="/blogs" component={Blogs}/>
                <Route path="/inspire" component={Inspire}/>
                <Route path="/news" component={News}/> */}
                <Route path="*" element={<NotFound />} />
              </Routes>
            </main>
          <footer>
            &copy; andyhill.us { new Date().getFullYear() }
          </footer>
          </Col>
      </Row>
    </Container>
  </div>
);

export default AppView;
