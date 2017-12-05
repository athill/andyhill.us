import { find } from 'lodash';
import React from 'react';
import { Alert, Col, Row } from 'react-bootstrap';
import { NavLink,  Route } from 'react-router-dom';

import './news.scss';

const categories = ['Wires', 'Left', 'Right', 'Libtertarian', 'Government', 'TV', 'Print', 'Radio', 'Congress', 'Indiana', 'Bloomington'];

const Error = ({ children }) => (
	<Alert bsStyle="danger">{ children }</Alert>
);



class Category extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
        	loadingState: 'loading',
        	data: {},
        	category: null
        }
        this._update = this._update.bind(this);
    }


    _update(props) {
    	const category = props.match.params.category || 'Wires';
    	const statedata = this.state.data;
    	if (statedata[category]) {
    		this.setState({
    			category
    		});
    		return;
    	}
    	this.setState({
    		loadingState: 'loading'
    	});
    	fetch(`/api/news/${category}`)
    		.then(response => response.json()
    			.then(data => {
    				this.setState({
    					loadingState: 'loaded',
    					data: {
    						...statedata,
    						[category]: data
    					},
    					category
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

    componentDidMount() {
    	this._update(this.props);
    }

	// shouldComponentUpdate(nextProps, nextState) {
	// 	const params = this.props.match.params;
	// 	const nextParams = nextProps.match.params;
	// 	const ok = params.category && nextParams.category && params.category === nextParams.category;
	// 	console.log('should', !ok);
	// 	return !ok;
	// }

	componentWillReceiveProps(nextProps) {
		const params = this.props.match.params;
		const nextParams = nextProps.match.params;
		if (params.category && nextParams.category && params.category === nextParams.category) {
			return;
		}
    	this._update(nextProps);
    }    

    render() {
    	const { loadingState, category } = this.state;
    	if (loadingState === 'loading') {
    		return <div><i className="fa fa-cog fa-3x fa-spin"></i> Loading ...</div>;
    	} else if (loadingState === 'fail') {
    		<Error>Sorry, something went wrong</Error>;
    	}
    	return (
    		<h3>{ category }</h3>
    	);
    }	
}

const CategoryWrapper = (props) => (
	<Category {...props} />
);

const NewsPage = ({ match }) => (
	<Row id="news">
    	<Col md={1}></Col>
    	<Col md={10}>
    		<h2>News</h2>
    		<ul className="nav">
    		{
    			categories.map(category => <li key={category}><NavLink activeClassName="active" exact to={`/news/${category}`}>{ category }</NavLink></li>)
    		}
    		</ul>
    		<Route path={match.url} exact render={CategoryWrapper} />
    		<Route path={`${match.url}/:category`} render={CategoryWrapper} />
    	</Col>
	</Row>
);

export default NewsPage;