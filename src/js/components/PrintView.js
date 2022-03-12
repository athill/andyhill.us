import { useEffect } from 'react';
import { Route, Routes } from 'react-router-dom';

import PrintRecipe from "./pages/recipes/PrintRecipe";

const PrintView = () => {
  useEffect(() => {

    document.body.style.backgroundColor = 'white';
    document.body.style.color = 'black';
    console.log('ran it');
  }, []);
  return (
    <Routes>
      <Route path="/recipes/:id" element={<PrintRecipe />}/>
    </Routes>
  );
}
export default PrintView;
