import React, { Component } from 'react';
import { Col, Grid, Row } from 'react-bootstrap';
import { NavLink, Link, Router, Route } from 'react-router-dom';


import history from '../history';
import Home from './pages/Home';
import Resume from './pages/resume';
import Portfolio from './pages/portfolio';

const navigation = [
    { display: 'Home', href: '/' },
    { display: 'Resume', href: '/resume/' },
    { display: 'Portfolio', href: '/portfolio/' },
];

const Navigation = ({ onLinkClick }) => (
    <ul>
        {
            navigation.map(({ display, href }) => <li key={href}><NavLink activeClassName="active" exact to={href} onClick={ onLinkClick }>{ display }</NavLink></li>)
        }
        <li><a href="/news/">News</a></li>
        <li><a href="/pictures/">Pictures</a></li>
        <li><a href="/recipes/">Recipes</a></li>
        <li><a href="/blogs.php">Blogs</a></li>
        <li><a href="/inspire/">Inspiration</a></li>
        <li><a href="/d3/">D3.js</a></li>
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

const Header = () => (
    <div className="app-header">
        <div className="desktop-header">
            <div className="img-container">
                <img src="/images/header/house.jpg" alt="" className="header-img"  />
                <img src="/images/header/band.jpg" alt="" className="header-img"/>
                <img src="/images/header/showwater.jpg" alt="" className="header-img"/>
                <img src="/images/header/wfhb.jpg" alt="" className="header-img"/> 
                <h1 className="page-title">andyhill.us</h1>
            </div>                            
            

            <nav id="nav" role="navigation">
                <Navigation />
            </nav>
        </div>                                 
    </div>
);

class App extends Component {
    render() {
        return (<Router history={history}>  
                <Grid>
                    <Row>
                        <Col md={1} className="site-side-padding"></Col>
                        <MobileHeader />
                        <Col md={10} sm={12} id="app-container">
                            <Header />
                            <main id="main">
                                <Route path="/" exact component={Home}/>
                                <Route path="/resume" component={Resume}/>
                                <Route path="/portfolio" component={Portfolio}/>
                            </main>
                            <footer>
                                &copy; andyhill.us 2017
                            </footer>
                        </Col>
                    </Row>
                </Grid>
            </Router>);
    }
};

export default App;
