window.$ = window.jQuery = require('jquery')
require('./bootstrap');

import IndexController from './IndexController';

new IndexController(document.getElementById('app'));

import React from 'react';
import { render } from 'react-dom';

import App from './components/App';

render(<App />, document.getElementById('app'));