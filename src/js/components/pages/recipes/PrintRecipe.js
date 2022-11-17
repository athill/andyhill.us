import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';

import Recipe from './Recipe';

const PrintRecipe = () => {
  const { id } = useParams();
  const [recipe, setRecipe] = useState(null);
  useEffect(() => {
    const fetchData = async () => {
      const response = await fetch(`/api/recipes/${id}`);
      const recipe = await response.json()
      setRecipe(recipe);
    };
    fetchData();
  }, [recipe, id]);
  return (
    <div style={{ margin: '6em' }}>
      {
        recipe ? <Recipe recipe={recipe} isScreenDisplay={false} /> : null
      }

    </div>
  )
};

export default PrintRecipe;
