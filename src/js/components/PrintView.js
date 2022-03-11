import { Route, Routes } from 'react-router-dom';

import PrintRecipe from "./pages/recipes/PrintRecipe";

const PrintView = () => (
  <Routes>
    <Route path="/recipes/:id" element={<PrintRecipe />}/>
  </Routes>
);

export default PrintView;
