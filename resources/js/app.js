import React from 'react';
import ReactDOM from 'react-dom/client';

import Test from './components/Test';

const test = document.getElementById('test');

if (test) {
    ReactDOM.createRoot(test).render(<Test />);
}
