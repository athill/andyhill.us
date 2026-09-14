import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faBars } from '@fortawesome/free-solid-svg-icons';
import React from 'react';
import { Link, NavLink, Route, Routes } from 'react-router-dom';

import Covers from './pages/covers';
import Home from './pages/Home';
import NotFound from './NotFound';
import Recipes from './pages/recipes';
import Resume from './pages/resume';

// import './appview.css';

const navigation = [
  { display: 'Home', href: '/' },
  { display: 'Resume', href: '/resume/' },
  { display: 'Covers', href: '/covers/' },
  { display: 'Recipes', href: '/recipes/' },
];

const Navigation = ({ onLinkClick }) => {
  const activeClasses = 'bg-white text-black visited:text-black';
  const inactiveClasses = 'bg-black text-white visited:text-white hover:bg-[#999]';
  return (
    <ul className="sm:flex w-full">
        {
            navigation.map(({ display, href }) => (
              <li key={href} className="block flex-1">
                <NavLink
                    className={({ isActive }) => `${isActive ? activeClasses : inactiveClasses} width-100 block text-center p-1`}
                    to={href}
                    onClick={ onLinkClick }>
                      { display }
                </NavLink>
              </li>
            ))
        }
    </ul>
  );
};

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
          <div className="block sm:hidden">
              <div className="mobile-navbar">
                  <h1 className="mobile-navbar-title"><Link to="/">andyhill.us</Link></h1>
                  <span className="button" onClick={this._menuToggle}>
                    <FontAwesomeIcon icon={faBars} />
                  </span>
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
  <div className="hidden sm:block">
    <div className="flex bg-gray relative justify-between bg-[#999] p-3 rounded-md m-2">
        {
            headerImages.map(({ src }) => <img key={ src } src={"/images/header/" + src} alt="" className="header-img"  />)
        }
        <h1 className="flex-none absolute bottom-4 left-4 text-white text-4xl text-shadow-[3px_3px_2px_gray]">andyhill.us</h1>
    </div>

    <nav id="nav" role="navigation">
        <Navigation />
    </nav>
  </div>
);

const AppView = () => (
  <div className="flex justify-center">
    <div className="bg-[#444] sm:mt-6 sm:mb-6 sm:w-80/100 md:w-60/100 sm:rounded-md">
      <MobileHeader />
      <Header />
      <main className="p-4">
        <Routes>
          <Route path="/" element={<Home />}/>
          <Route path="resume" element={<Resume />}/>
          <Route path="/recipes" element={<Recipes />}/>
          <Route path="/covers" element={<Covers />}/>
          <Route path="*" element={<NotFound />} />
        </Routes>
      </main>
    <footer className="p-2 text-center bg-[#ccc] text-black rounded-b-md">
      &copy; andyhill.us { new Date().getFullYear() }
    </footer>
    </div>
  </div>
);

export default AppView;
