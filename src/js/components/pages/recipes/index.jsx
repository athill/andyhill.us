import { useState, useEffect } from 'react';
import { Alert, Col, Form, ListGroup, Row} from 'react-bootstrap';

import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from "@/components/ui/tabs"
import { useLocation } from 'react-router-dom';
import { Input } from "@/components/ui/input"

import Recipe from './Recipe';
import { getPagination } from '../../../utils/PrimaryPagination';

// import './recipes.css';

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
  <form style={{ paddingBottom: '1em' }}>
  	<fieldset>
  		<legend>Filter</legend>
	    <div className="flex">
        <div className="flex-1">
            <Input type="text" placeholder="Text" onChange={onTextChange} />
        </div>
	      <div className="flex-1">
	        <Select id="category" label="Category" options={categories} onChange={onCategoryChange} />
        </div>
	      <div className="flex-1">
	        <Select id="cuisine" label="Cuisine" options={cuisines} onChange={onCuisineChange} />
        </div>
      </div>
    </fieldset>
  </form>
);

const Recipes = ({ recipes }) =>  {
  const location = useLocation();
  const activeKey = location.hash || (recipes.length && `#recipe-${recipes[0].id}`);
  return recipes.length && (
    <Tabs defaultValue={activeKey} className="grid grid-cols-2" orientation="vertical">
        <TabsList className="col-span-1">
            {
              recipes.map(recipe => <TabsTrigger key={recipe.id} value={`#recipe-${recipe.id}`}>{recipe.title}</TabsTrigger>)
            }
        </TabsList>
        <div className="col-span-1">
            {
              recipes.map(recipe => <TabsContent key={recipe.id} value={`#recipe-${recipe.id}`}><Recipe recipe={recipe} /></TabsContent>)
            }
        </div>
    </Tabs>
  );
};

const maxOptionLength = 15;		//// max length of filter option display value

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
        const recipes = await response.json();
        const categories = new Set();
        const cuisines = new Set();
        recipes.sort((a, b) => a.title.localeCompare(b.title));
        console.log(recipes);
        recipes.forEach(recipe => {
          categories.add(recipe.category);
          cuisines.add(recipe.cuisine);
          recipe.instructions = recipe.instructions.split('\n');
          if (recipe.notes) {
            recipe.notes = recipe.notes.split('\n');
          }
        });
        // const { categories, cuisines, recipes } = result;
        setRecipeData({
          categories: Array.from(categories),
          cuisines: Array.from(cuisines),
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
      <title>andyhill.us - Recipes</title>
      <h2 id="top" className="text-3xl font-bold underline">Recipes</h2>
      <p>
        I love to cook and used <a href="http://thinkle.github.io/gourmet/" target="_blank" rel="noreferrer">Gourmet</a> recipe manager for years.
        However, It's only available on Windows, so I
        wrote <a href="https://github.com/athill/gourmet2" target="_blank" rel="noreferrer">my own recipe manager in JavaScript</a> and
        imported my recipes from Gourmet. The content of this page generated from the data in my recipe manager.
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
