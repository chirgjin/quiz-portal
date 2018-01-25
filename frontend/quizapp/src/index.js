import React from 'react';
import ReactDOM from 'react-dom';
import './css/index.css';
// import App from './components/App.jsx';
import Login from './components/Login.jsx';
import registerServiceWorker from './registerServiceWorker';

ReactDOM.render(<Login />, document.getElementById('main-container'));
registerServiceWorker();
