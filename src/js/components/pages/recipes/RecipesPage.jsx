import { useState, useEffect } from 'react';
import { useSearchParams } from 'react-router-dom';
import {
  Alert,
  AlertDescription,
} from "@/components/ui/alert"

import {
  Select as SelectUI,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from "@/components/ui/tabs"
import { useLocation } from 'react-router-dom';
import ClearableInput from '@/components/clearable-input';

import Recipe from './Recipe';
import { getPagination } from '../../../utils/PrimaryPagination';
import { Button } from '@/components/ui/button';

// import './recipes.css';

const Select = ({ label, onChange, options=[], value }) => {
  const items = options.map(value => ({ label: value, value }));
  return (
    <SelectUI items={items} onValueChange={onChange} value={value}>
      <SelectTrigger>
        <SelectValue placeholder={label} />
      </SelectTrigger>
      <SelectContent>
        <SelectGroup>
          {
            items.map(({label, value}, i) => <SelectItem key={i} value={value}>{label}</SelectItem>)
          }
        </SelectGroup>
      </SelectContent>
    </SelectUI>
  );
};

const RecipesForm = ({ categories, cuisines, filters }) => {
  const [searchParams, setSearchParams] = useSearchParams(location.search);
  const onItemChange = (key) => {
    return e => {
      console.log(e)
      return setSearchParams({
      ...filters,
      [key]: e });
    };
  };
  return (
    <form style={{ paddingBottom: '1em' }}>
      <fieldset>
        <legend>Filter</legend>
        <div className="flex justify-start gap-5">
              <ClearableInput
                value={searchParams.get('text') || ''}
                setValue={onItemChange('text')}
                placeholder="Text"
                />
            <Select
              label="Category"
              options={categories}
              onChange={onItemChange('category')}
              value={searchParams.get('category') || ''}
            />
            <Select
              label="Cuisine"
              options={cuisines}
              onChange={onItemChange('cuisine')}
              value={searchParams.get('cuisine') || ''}
            />
            <Button
              type="button"
              onClick={() => setSearchParams({
                text: '',
                category: '',
                cuisine: ''
              })}
            >
              Clear All
            </Button>

        </div>
      </fieldset>
    </form>
  );
};

const Recipes = ({ recipes }) =>  {
  const location = useLocation();
  const activeKey = location.hash || (recipes.length && `#recipe-${recipes[0].id}`);
  return recipes.length && (
    <Tabs defaultValue={activeKey} className="grid grid-cols-2 gap-4" orientation="vertical">
        <TabsList className="col-span-1">
            {
              recipes.map(recipe => <TabsTrigger key={recipe.id} value={`#recipe-${recipe.id}`}>{recipe.title}</TabsTrigger>)
            }
        </TabsList>
        <div className="col-span-1 p-4">
            {
              recipes.map(recipe => <TabsContent key={recipe.id} value={`#recipe-${recipe.id}`}><Recipe recipe={recipe} /></TabsContent>)
            }
        </div>
    </Tabs>
  );
};

const RecipesPage = () => {
  const [ recipeData, setRecipeData ] = useState({
    categories: [],
    cuisines: [],
    recipes: [],
  });
  const [ searchParams ] = useSearchParams(location.search);
  const [ loadingState, setLoadingState ] = useState('loading');
  const [ activePage, setActivePage ] = useState(0);
  const pageSize = 15;
  let curated = [...recipeData.recipes];
  const { Pagination, slice } = getPagination({activePage, items: curated || [], pageSize, setActivePage});
  const filters = {
    text: searchParams.get('text') || '',
    category: searchParams.get('category') || '',
    cuisine: searchParams.get('cuisine') || '',
  };

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch('/api/recipes');
        const recipes = await response.json();
        const categories = new Set();
        const cuisines = new Set();
        recipes.sort((a, b) => a.title.localeCompare(b.title));
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
        setLoadingState('fail');
      }
    };
    fetchData();
  }, []);

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
      <h2>Recipes</h2>
      <p>
        I love to cook and used <a href="http://thinkle.github.io/gourmet/" target="_blank" rel="noreferrer">Gourmet</a> recipe manager for years.
        However, It's only available on Windows, so I
        wrote <a href="https://github.com/athill/gourmet2" target="_blank" rel="noreferrer">my own recipe manager in JavaScript</a> and
        imported my recipes from Gourmet. The content of this page generated from the data in my recipe manager.
      </p>
      <RecipesForm
					categories={recipeData.categories}
					cuisines={recipeData.cuisines}
          filters={filters}
				/>

				{ loadingState === 'loading' && <div><i className="fa fa-refresh fa-cog fa-3x fa-fw"></i> Loading ...</div> }
				{ loadingState === 'fail' && (
          <Alert variant="destructive">
            <AlertDescription>
              We&apos;re sorry, something went wrong.
            </AlertDescription>
          </Alert>
        ) }
        { loadingState === 'loaded' &&
          <>
          <div className="flex justify-between">
            <div>
              <Pagination />
            </div>
            <div>{recipes.length}&nbsp;results</div>
          </div>
          <Recipes recipes={slice(recipes)} />
          </> }
    </>
  )
};

export default RecipesPage;
