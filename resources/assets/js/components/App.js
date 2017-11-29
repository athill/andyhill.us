import React, { Component } from 'react';
import { Col, Grid, Row } from 'react-bootstrap';
// import { Provider } from 'react-redux';
import { NavLink, Router, Route } from 'react-router-dom';


// import AppNavbar from './AppNavbar';
import history from '../history';
import Home from './pages/Home';
import Resume from './pages/resume';
import Portfolio from './pages/portfolio';
// import Import from './pages/import';
// import createStore from '../store';
// import reducers from '../modules/reducer';

// const store = createStore(reducers(), window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__());

const Navigation = ({ className=null }) => (
    <ul className={className}>
        <li><NavLink activeClassName="active" to="/">Home</NavLink></li>
        <li><NavLink activeClassName="active" to="/resume/">Resume</NavLink></li>
        <li><NavLink activeClassName="active" to="/portfolio/">Portfolio</NavLink></li>
        <li><a href="/news/">News</a></li>
        <li><a href="/pictures/">Pictures</a></li>
        <li><a href="/recipes/">Recipes</a></li>
        <li><a href="/blogs.php">Blogs</a></li>
        <li><a href="/inspire/">Inspiration</a></li>
        <li><a href="/d3/">D3.js</a></li>
    </ul>
);

class MobileNavbar extends React.Component {
    constructor(props) {
        super(props);

        this.state = { showNav: false };
    }

    render() {
        return (
            <div>
                <div className="mobile-navbar">
                    <h1 className="title">andyhill.us</h1>
                    <span className="button">X</span>
                </div>
                { this.state.showNav && <Navigation /> }
            </div>
        )
    }
}

const Header = () =>(
    <div className="app-header">
        <div className="mobile-header hidden-md hidden-lg">
            <MobileNavbar />
        </div>
        <div className="desktop-header hidden-xs hidden-sm">
            <div className="img-container">
                <img src="/images/header/house.jpg" alt="" className="header-img"  />
                <img src="/images/header/band.jpg" alt="" className="header-img"/>
                <img src="/images/header/showwater.jpg" alt="" className="header-img"/>
                <img src="/images/header/wfhb.jpg" alt="" className="header-img"/> 
                <h1 className="page-title">andyhill.us</h1>
            </div>                            
            

            <nav id="nav" role="navigation" className="col-sm-12 col-xs-2">
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
                        <Col md={1} className="hidden-sm site-side-padding"></Col>
                        <Col md={10} sm={12} id="app-container">
                            <Header />
                            <Route path="/" exact component={Home}/>
                            <Route path="/resume" component={Resume}/>
                            <Route path="/portfolio" component={Portfolio}/>
                            <footer>
                                &copy; andyhill.us 2017
                            </footer>
                        </Col>
                    </Row>
                </Grid>
            </Router>);
    }
  // render() {
  //   return (
  //   <Provider store={store}>
  //       <Router history={history}>  
  //           <div>  
  //               <AppNavbar />
  //               <Grid>
  //                   <Row>
  //                       <Col md={12}>
  //                           <PrivateRoute path="/" exact component={Home}/>
  //                           <Route path="/login" component={Login}/>
  //                           <Route path="/demo" exact component={Home}/>
  //                           <Route path="/password-reset" exact component={PasswordReset}/>
  //                           <Route path="/register" exact component={Register}/>
  //                           <Route path="/import" exact component={Import}/>
  //                       </Col>
  //                   </Row>
  //               </Grid>
  //           </div>
  //       </Router>
  //   </Provider>
  //   )
  // }
};

export default App;
