import React, { useState, useEffect } from 'react';
import { Alert, Col, Form, ListGroup, Row, Tab } from 'react-bootstrap';
import { Helmet } from 'react-helmet';

import Recipe from './Recipe';
import { getPagination } from '../../../utils/PrimaryPagination';

import './recipes.css';

const Select = ({ id, label, onChange, options=[] }) => (
    <Form.Group controlId={id}>
      <Form.Label>{ label }:</Form.Label>
      {' '}
      <Form.Select onChange={onChange}>
      <option></option>
      {
      	options.map(({display, value}, i) => <option key={i} value={value}>{display}</option>)
      }
      </Form.Select>
    </Form.Group>
);

const RecipesForm = ({ categories, cuisines, onCategoryChange, onCuisineChange, onTextChange }) => (
  <Form style={{ paddingBottom: '1em' }}>
  	<fieldset>
  		<legend>Filter</legend>
	    <Row>
        <Col>
          <Form.Group controlId="filter">
            <Form.Label>Text:</Form.Label>
            {' '}
            <Form.Control type="text" onChange={onTextChange} />
          </Form.Group>
        </Col>
	      <Col>
	        <Select id="category" label="Category" options={categories} onChange={onCategoryChange} />
        </Col>
	      <Col>
	        <Select id="cuisine" label="Cuisine" options={cuisines} onChange={onCuisineChange} />
        </Col>
      </Row>
    </fieldset>
  </Form>
);

const Recipes = ({ recipes }) => (
	<Tab.Container>
    <Row>
      <Col sm={4}>
        <ListGroup defaultActiveKey={`#recipe-{recipes.length && recipes[0].id}`}>
          {
            recipes.map(recipe => <ListGroup.Item key={recipe.id} action href={`#recipe-${recipe.id}`}>{recipe.title}</ListGroup.Item>)
          }
        </ListGroup>
      </Col>
      <Col sm={8}>
        <Tab.Content>
          {
            recipes.map(recipe => <Tab.Pane key={recipe.id} eventKey={`#recipe-${recipe.id}`}><Recipe recipe={recipe} /></Tab.Pane>)
          }
          <Tab.Pane eventKey="#link2">Tab pane content 2</Tab.Pane>
        </Tab.Content>
      </Col>
    </Row>
	</Tab.Container>
);

const maxOptionLength = 15;		//// max length of filter option display value
class RecipesPage extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
        	recipes: [],
        	loadingState: 'loading',
        	textFilter: null,
        	categoryFilter: null,
        	cuisineFilter: null,
        	ingredientFilter: null,
        	categories: [],
        	cuisines: [],
        	ingredients: []
        };
        this._filter = this._filter.bind(this);
        this._getOption = this._getOption.bind(this);
        this._onItemChange = this._onItemChange.bind(this);

    }


    _filter() {
    	let { categoryFilter, cuisineFilter, ingredientFilter, textFilter, recipes} = this.state;
    	if (!categoryFilter && !cuisineFilter && !ingredientFilter && !textFilter) {
    		return recipes;
    	}
    	const inString = (needle, haystack) => !needle ? true : haystack.toLowerCase().includes(needle.toLowerCase());
    	return recipes.filter(recipe => {
    		return inString(categoryFilter, recipe.category) &&
    			inString(cuisineFilter, recipe.cuisine) &&
    			inString(ingredientFilter, recipe.ingredients.map(ingredient => ingredient.item).join(' ')) &&
    			(inString(textFilter, recipe.category) ||
						inString(textFilter, recipe.cuisine) ||
						inString(textFilter, recipe.title) ||
						inString(textFilter, recipe.instructions.join(' ')));
    	});
    }

    _onItemChange(key) {
    	return e => this.setState({ [key]: e.target.value });
    }

    _getOption(option) {
      //// remove everything after semi-colon
      const value =  option.split(';')[0];
      const display = (value.length > maxOptionLength) ? value.substring(0, maxOptionLength) + '...' : value;
      return {
        display,
        value
      };
    }

    componentDidMount() {
      fetch(`/api/recipes`)
        .then(response => response.json())
        .then((response) => {
          const { categories, cuisines, ingredients, recipes } = response;
      		this.setState({
        			loadingState: 'loaded',
        			categories,
        			cuisines,
        			ingredients,
        			recipes
        		});
        })
    		.catch(error => {
    			console.error(error);
    			this.setState({ loadingState: 'fail' });
    		});
    }

	render() {
		const recipes = this._filter();
		const { categories, cuisines, loadingState, ingredients } = this.state;
		return (
			<div>
        <Helmet>
          <title>andyhill.us - Recipes</title>
        </Helmet>
				<h2 id="top">Recipes</h2>
				<p>
					I love to cook and use <a href="http://thinkle.github.io/gourmet/" target="_blank" rel="noreferrer">Gourmet</a> recipe manager.
					The content of this page is from an XML export of my recipes in Gourmet.
				</p>
				<RecipesForm
					categories={categories}
					cuisines={cuisines}
					ingredients={ingredients}
					onCategoryChange={this._onItemChange('categoryFilter')}
					onCuisineChange={this._onItemChange('cuisineFilter')}
					onTextChange={this._onItemChange('textFilter')}
				/>
				<ul id="recipe-list">
				{
					recipes.map(recipe => <li key={recipe.id}><a href={`#${recipe.name}`}>{ recipe.title }</a></li>)
				}
				</ul>
				{ loadingState === 'loading' && <div><i className="fa fa-refresh fa-cog fa-3x fa-fw"></i> Loading ...</div> }
				{ loadingState === 'loaded' && <Recipes recipes={recipes} /> }
				{ loadingState === 'fail' && <Alert bsStyle="danger">We&apos;re sorry, something went wrong.</Alert> }
			</div>
		);
	}
}

const RecipesPage2 = () => {
  const [ recipeData, setRecipeData ] = useState({
    categories: [],
    cuisines: [],
    recipes: [],
  });
  const [ filters, setFilters ] = useState({
    text: null,
    category: null,
    cuisine: null,
  });
  const [ loadingState, setLoadingState ] = useState('loading');
  const [ activePage, setActivePage ] = useState(0);
  const pageSize = 15;
  let curated = [...recipeData.recipes];
  const { Pagination, slice } = getPagination({activePage, items: curated || [], pageSize, setActivePage});

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch('/api/recipes');
        const result = await response.json();
        const { categories, cuisines, recipes } = result;
        setRecipeData({
          categories,
          cuisines,
          recipes
        });
        setLoadingState('loaded');
      } catch (e) {
        console.log(e);
        setLoadingState('fail');
      }
    };
    fetchData();
  }, []);

  const onItemChange = (key) => {
    return e => setFilters({ ...filters, [key]: e.target.value });
  };
  const inString = (needle, haystack) => !needle ? true : haystack.toLowerCase().includes(needle.toLowerCase());

  const filterItems =  () => {
    if (!filters.category && !filters.cuisine && !filters.text) {
      return curated;
    }

    return curated.filter(recipe => {
      return inString(filters.category, recipe.category) &&
        inString(filters.cuisine, recipe.cuisine) &&
        (inString(filters.text, recipe.category) ||
          inString(filters.text, recipe.cuisine) ||
          inString(filters.text, recipe.title) ||
          inString(filters.text, recipe.instructions.join(' ')));
    });
  }

  const recipes = filterItems(curated);
  return (
    <>
      <Helmet>
        <title>andyhill.us - Recipes</title>
      </Helmet>
      <h2 id="top">Recipes</h2>
      <p>
        I love to cook and use <a href="http://thinkle.github.io/gourmet/" target="_blank" rel="noreferrer">Gourmet</a> recipe manager.
        The content of this page is from an XML export of my recipes in Gourmet.
      </p>
      <RecipesForm
					categories={recipeData.categories}
					cuisines={recipeData.cuisines}
					onCategoryChange={onItemChange('category')}
					onCuisineChange={onItemChange('cuisine')}
					onTextChange={onItemChange('text')}
				/>

				{ loadingState === 'loading' && <div><i className="fa fa-refresh fa-cog fa-3x fa-fw"></i> Loading ...</div> }
				{ loadingState === 'fail' && <Alert bsStyle="danger">We&apos;re sorry, something went wrong.</Alert> }
        { loadingState === 'loaded' &&
          <>
          <div style={{ display: 'inline-flex' }}>
            <Pagination />
            <div><strong>&nbsp;{recipes.length}  results</strong></div>
          </div>
          <Recipes recipes={slice(recipes)} />
          </> }
    </>
  )
};

export default RecipesPage2;
