import React from 'react';
import { Helmet } from "react-helmet";
import { BrowserRouter, Route, Routes } from 'react-router-dom';

import 'bootstrap/dist/css/bootstrap.css';

import AppView from './AppView';
import PrintView from './PrintView';

const App = () => (
  <BrowserRouter>
    <Helmet>
      <title>andyhill.us</title>
    </Helmet>
    <Routes>
        <Route path="/print/*" element={<PrintView />} />
        <Route path="*" element={<AppView />} />
    </Routes>
  </BrowserRouter>
);

export default App;
