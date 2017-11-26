import React, { Component } from 'react';
import { Col, Grid, Row } from 'react-bootstrap';
// import { Provider } from 'react-redux';
// import { Router, Route } from 'react-router-dom';


// import AppNavbar from './AppNavbar';
// import history from '../history';
// import Login from './pages/login';
// import Home from './pages/home';
// import PasswordReset from './pages/password-reset';
// import PrivateRoute from './PrivateRoute';
// import Register from './pages/register';
// import Import from './pages/import';
// import createStore from '../store';
// import reducers from '../modules/reducer';

// const store = createStore(reducers(), window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__());

const Header = () =>(
    <div className="app-header">
        <div className="img-container">
            <img src="/images/header/house.jpg" alt="" className="header-img"  />
            <img src="/images/header/band.jpg" alt="" className="header-img"/>
            <img src="/images/header/showwater.jpg" alt="" className="header-img"/>
            <img src="/images/header/wfhb.jpg" alt="" className="header-img"/> 
            <h1 className="page-title">andyhill.us</h1>
        </div>                            
        

        <nav id="nav" role="navigation" class="col-sm-12 col-xs-2">
            <a href="#nav" title="Show navigation">Show navigation</a>
            <a href="#" title="Hide navigation">Hide navigation</a>
            <ul>
                <li className="active"><a href="/">Home</a></li>
                <li><a href="/resume/">Resume</a></li>
                <li><a href="/portfolio/">Portfolio</a></li>
                <li><a href="/news/">News</a></li>
                <li><a href="/pictures/">Pictures</a></li>
                <li><a href="/recipes/">Recipes</a></li>
                <li><a href="/blogs.php">Blogs</a></li>
                <li><a href="/inspire/">Inspiration</a></li>
                <li><a href="/d3/">D3.js</a></li>
            </ul>
        </nav>                                 
    </div>
);

class App extends Component {
    render() {
        return (<div>  
                <Grid>
                    <Row>
                        <Col md={12} id="app-container">
                            <Header />
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                            <footer>
                                &copy; andyhill.us 2017
                            </footer>
                        </Col>
                    </Row>
                </Grid>
            </div>);
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
