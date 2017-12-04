import { find } from 'lodash';
import React from 'react';
import { Alert, Col, Row } from 'react-bootstrap';
import { NavLink,  Route } from 'react-router-dom';

import './inspire.scss';


const ucfirst = string => string.charAt(0).toUpperCase() + string.slice(1);

const Error = ({ children }) => (
	<Alert bsStyle="danger">{ children }</Alert>
);

const AreaNavigation = ({ data, area }) => {
	if (!Object.keys(data).length) {
		return null;
	} else if (!(area in data)) {
		<Error>Invalid area path.</Error>
	} else {
		return 	(
			<ul>
			{
				data[area].map(text => (
					<li key={text.key}><NavLink activeClassName="active" exact to={`/inspire/${area}/${text.key}`}>{ text.title }</NavLink></li>
				))
			}
			</ul>
		);
	}
};

class Navigation extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
        	selected: null
        }
        this._onAreaClick = this._onAreaClick.bind(this);
    }		

    _onAreaClick(area) {
    	const selected = this.state.selected === area ? null : area;
    	this.setState({
    		selected
    	});
    }

	render() {
		const { data, mobile } = this.props;
		const { selected } = this.state;
		return (<ul>
			{
				Object.keys(data).map(area => (
		 			<li key={area}>
		 				{
		 					mobile ?
		 						<div onClick={() => this._onAreaClick(area)}>{ ucfirst(area) }</div> :
		 						<NavLink activeClassName="active" exact to={`/inspire/${area}`}>{ ucfirst(area) }</NavLink> 
		 							
		 				}
		 				{ (!(!!mobile) || selected === area) && <AreaNavigation data={data} area={area} /> }
		 			</li>
				))
			}
			</ul>
		);
	}
}

const DesktopNavigation = ({ data }) => (
	<div className="side-nav nav">
		<Navigation data={data} />
	</div>
);

const MobileNavigation = ({ data }) => (
	<div className="mobile-nav nav">
		<Navigation data={data} mobile />
	</div>	
);

//// content route components
const Home = () => (
	<div>
		<p>
		Some words that inspire me.
		</p>
	</div>
);

const Area = ({ data, match }) => {
	const area = match.params.area;
	return (
		<div>
			<h3>{ ucfirst(area) }</h3>
			<AreaNavigation area={area} data={data} />
		</div>
	);
};

const Quote = ({ data, match }) => {
	const { area, quote } = match.params;
	//// data not loaded
	if (!Object.keys(data).length) {
		return null;
	}
	//// invalid area
	if (!(area in data)) {
		return <Error>Invalid area path.</Error>
	}

	const quoteData = find(data[area], ['key', quote]);
	//// invalid quote
	if (!quoteData) {
		return <Error>Invalid quote path.</Error>
	}
	//// good to go
	const { title, content, credits } = quoteData;
	return (
		<div>
			<h3>{ title }</h3>
			<div className="quote-content">{ content.split('\n').map((line, i) => <div key={i}>{line}</div>) }</div>
			<p><em>{ credits }</em></p>
		</div>
	);
};

class InspirePage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
        	loadingState: 'loading',
        	data: {}
        }
        // this._filter = this._filter.bind(this);
    }	

    componentDidMount() {
    	fetch('/api/inspire')
    		.then(response => response.json()
    			.then(data => {
    				this.setState({
    					loadingState: 'loaded',
    					data
    				});
    			})
    		)
    		.catch(error => {
    			console.error('something went wrong', error);
    			this.setState({
    				loadingState: 'fail'
    			});
    		});
    }

    render() {
    	const match = this.props.match;
    	const { data, loadingState } = this.state;
    	const AreaWrapper = (props) => <Area data={data} {...props} />;
    	const QuoteWrapper = (props) => <Quote data={data} {...props} />;
    	return (
    		<Row id="inspire">
		    	<Col md={3}>
		    		<MobileNavigation data={data} />
		    		<DesktopNavigation data={data} />
		    	</Col>
		    	<Col md={9}>
		    		<h2>Inspiration</h2>
		    		{ loadingState === 'loading' && <div><i className="fa fa-cog fa-3x fa-fw"></i> Loading ...</div> }
		    		{ loadingState === 'fail' && <Error>Sorry, something went wrong</Error>}
		    		<Route path={`${match.url}`} exact component={Home} />
		    		<Route path={`${match.url}/:area`} exact render={AreaWrapper} />
		    		<Route path={`${match.url}/:area/:quote`} component={QuoteWrapper} />
		    	</Col>
	    	</Row>);
    }
}

export default InspirePage;