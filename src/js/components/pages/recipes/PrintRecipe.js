import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';

import Recipe from './Recipe';

const PrintRecipe = () => {
  const { id } = useParams();
  const [recipe, setRecipe] = useState(null);
  useEffect(async () => {
    const response = await fetch(`/api/recipes/${id}`);
    const recipe = await response.json()
    setRecipe(recipe);
  }, [recipe]);
  return (
    <div style={{ margin: '2em' }}>
      {
        recipe ? <Recipe recipe={recipe} isScreenDisplay={false} /> : null
      }

    </div>
  )
};

export default PrintRecipe;
