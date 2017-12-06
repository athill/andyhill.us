import { find } from 'lodash';
import React from 'react';
import { Alert, Col, Row } from 'react-bootstrap';
import { NavLink,  Route } from 'react-router-dom';

import './news.scss';

const categories = ['Wires', 'Left', 'Right', 'Libtertarian', 'Government', 'TV', 'Print', 'Radio', 'Congress', 'Indiana', 'Bloomington'];

//// refactor/promote
const Error = ({ children }) => (
	<Alert bsStyle="danger">{ children }</Alert>
);

const Icon = ({ name, className, srText }) => (
	<span>
		<i className={`fa fa-${name} ${className}`} aria-hidden="true"></i>
		<span className="sr-only">{ srText }</span>
	</span>
);

////// page
//// danger zone (using html from feeds)
const Item = ({ date, description, link, title }) => (
	<span>
		<a href={link} className="feed-links elipsis" 
			title="" target="_blank" rel="noopener"><span dangerouslySetInnerHTML={{ __html: title }} /></a>
		<div className="feed-description">
			<div dangerouslySetInnerHTML={{ __html: description }} />
			<br /><br />
			Posted: <time>{ date }</time>
		</div>
	</span>
);
//// end danger zone

const Feed = ({ title, link, description, items }) => (
	<Col md={6}>
		<article>
			<header>
				<h3 className="elipsis" title={ title }>{ title }</h3>
				<nav>
					<a href={link} target="_blank" rel="noopener" title="link to site"
						><i className="fa fa-external-link" aria-hidden="true"></i>
					</a>
					<a href="#" className="feed-toggleall" title="expand all"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
</a>
				</nav>
			</header>
			<ul>
			{
				items.slice(0, 10).map((item, i) => <li key={i}><Item {...item} /></li> )
			}
			</ul>
		</article>
	</Col>
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
    	const { loadingState, data, category } = this.state;
    	if (loadingState === 'loading') {
    		return <div><i className="fa fa-cog fa-3x fa-spin"></i> Loading ...</div>;
    	} else if (loadingState === 'fail') {
    		<Error>Sorry, something went wrong</Error>;
    	}
    	return (
    		<Row>
    		{
    			data[category] && data[category].map((feed, i) => <Feed key={i} {...feed} />) 
    		}
    		</Row>
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