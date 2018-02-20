import { find } from 'lodash';
import React from 'react';
import { Alert, Col, OverlayTrigger, Row, Tooltip } from 'react-bootstrap';
import { Helmet } from 'react-helmet';
import { NavLink,  Route } from 'react-router-dom';
import slug from 'slug';

import './news.scss';

const categories = ['Wires', 'Left', 'Right', 'Libertarian', 'Government', 'TV', 'Print', 'Radio', 'Congress'];
// , 'Indiana', 'Bloomington'


const Icon = ({ name, className, srText, ...props }) => { 
	srText = props.title || srText;
	if (!srText) {
		throw new Error('Error in Icon: at least one of "title" or "srText" must be provided. If only "title" is provided, it will act as "srText" as well.');
	}
	return (
		<span {...props}>
			<i className={`fa fa-${name} ${className}`} aria-hidden="true"></i>
			<span className="sr-only">{ srText }</span>
		</span>
	);
}

//// danger zone (using html from feeds)
const Item = ({ date, description, link, showDescription, title }) => {
	const tooltip = <Tooltip id={slug(title)}><div dangerouslySetInnerHTML={{ __html: description }} /></Tooltip>;
	const Empty = ({ id }) => <span id={id}></span>;
	const empty = <Empty id={slug(title)} />;
	return (<span>
			<OverlayTrigger placement="bottom" overlay={showDescription ? empty : tooltip }>
				<a href={link} className="feed-links elipsis" 
					target="_blank" rel="noopener"><span dangerouslySetInnerHTML={{ __html: title }} /></a>
			</OverlayTrigger>				
			{ 
				showDescription && (<div className="feed-description">
							<div dangerouslySetInnerHTML={{ __html: description }} />
							<br /><br />
							Posted: <time>{ date }</time>
						</div>)
			}
		</span>);
};
//// end danger zone

class Feed extends React.Component {
	    constructor(props) {
        super(props);
        this.state = {
        	showDescriptions: false
        }
        this._toggleDescriptions = this._toggleDescriptions.bind(this);
    }

    _toggleDescriptions(e) {
    	e.preventDefault();
    	this.setState({
    		showDescriptions: !this.state.showDescriptions
    	});
    }

    render() {
    	const { error, title, link, description, items } = this.props;
    	const { showDescriptions } = this.state;
        if (error) {
            return (
                <Col md={6}>
                    <article>
                        <Alert bsStyle="danger">{ error }</Alert>
                    </article>
                </Col>
            );
        } else {
        	return (
                <Col md={6}>
    			     <article>
    					<header>
    						<h3 className="elipsis" title={ title }>{ title }</h3>
    						<nav>
    							<a href={link} target="_blank" rel="noopener" title="go to site">
    								<Icon name="external-link" srText="go to site" />
    							</a>
    							<a href="#" onClick={this._toggleDescriptions } title="expand all desciptions">
    								<Icon name={showDescriptions ? 'chevron-circle-up' : 'chevron-circle-down'} srText="expand all desciptions" />
    							</a>
    						</nav>
    					</header>
    					<ul>
    					{
    						items.slice(0, 10).map((item, i) => <li key={i}><Item showDescription={	showDescriptions } {...item} /></li> )
    					}	
    					</ul>
    				</article>
    			</Col>
    		);
        }
    }

}


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
    		<Alert bsStyle="danger">Sorry, something went wrong</Alert>;
    	}
    	return (
    		<Row className="feeds">
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
        <Helmet>
            <title>andyhill.us - News</title>
        </Helmet>    
    	<Col md={1}></Col>
    	<Col md={10}>
    		<ul className="nav">
    		{
    			categories.map(category => <li key={category}><NavLink activeClassName="selected" exact to={`/news/${category}`}>{ category }</NavLink></li>)
    		}
    		</ul>
    		<Route path={match.url} exact render={CategoryWrapper} />
    		<Route path={`${match.url}/:category`} render={CategoryWrapper} />
    	</Col>
	</Row>
);

export default NewsPage;