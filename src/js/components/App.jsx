import { ThemeProvider } from "@/components/theme-provider"
import { BrowserRouter, Route, Routes } from 'react-router-dom';

// import 'bootstrap/dist/css/bootstrap.css';

import AppView from './AppView';
import PrintView from './PrintView';

const App = () => (
  <ThemeProvider>
    <BrowserRouter>
        <title>andyhill.us</title>
      <Routes>
          <Route path="/print/*" element={<PrintView />} />
          <Route path="*" element={<AppView />} />
      </Routes>
    </BrowserRouter>
  </ThemeProvider>
);

export default App;
