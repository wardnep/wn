import React from 'react';
import ReactDOM from 'react-dom/client';

import Test from './components/Test';

function App() {
    return <h1>Hello React</h1>;
}

const container = document.getElementById('react-app');
const test = document.getElementById('test');

if (container) {
    ReactDOM.createRoot(container);
}

if (test) {
    ReactDOM.createRoot(test).render(<Test />);
}
