import { Menu } from 'lucide-react';
import React from 'react';
import { NavLink, Route, Routes } from 'react-router-dom';
import { ModeToggle } from "@/components/mode-toggle"
import { Button } from "@/components/ui/button"

import Covers from './pages/covers';
import Home from './pages/Home';
import NotFound from './NotFound';
import Recipes from './pages/recipes/RecipesPage';
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
              <div className="width-full flex flex-row justify-items-end gap-1 bg-header text-header-foreground">
                  <h1 className="text-5xl grow">andyhill.us</h1>
                  <div className="bg-header text-header-foreground">
                    <ModeToggle className="bg-header text-header-foreground" />
                  </div>
                  <Button className="size-8 p-3" variant="outline bg-header text-header-foreground" onClick={this._menuToggle}>
                    <Menu />
                  </Button>
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
    <div className="flex relative justify-between bg-header p-3 rounded-lg m-3">
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
  <div className="flex justify-center relative">
    <div className="hidden sm:block absolute top-2 right-2 flex-none">
      <ModeToggle />
    </div>
    <div className="sm:mt-6 sm:mb-6 sm:w-80/100 md:w-60/100 sm:rounded-lg bg-content">
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
    <footer className="p-2 text-center bg-header text-header-foreground rounded-b-md">

      &copy; andyhill.us { new Date().getFullYear() }
    </footer>
    </div>
  </div>
);

export default AppView;
