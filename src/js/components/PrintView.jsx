import { useEffect } from 'react';
import { Route, Routes } from 'react-router-dom';
import NotFound from './NotFound';

import PrintRecipe from "./pages/recipes/PrintRecipe";

const PrintView = () => {
  useEffect(() => {
    document.body.style.backgroundColor = 'white';
    document.body.style.color = 'black';
  }, []);
  return (
    <Routes>
      <Route path="/recipes/:id" element={<PrintRecipe />}/>
      <Route path="*" element={<NotFound />} />
    </Routes>
  );
}
export default PrintView;
