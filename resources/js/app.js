import React from 'react';
import ReactDOM from 'react-dom/client';

import Test from './components/Test';
import PositionSizing from './components/PositionSizing';

const test = document.getElementById('test');
const positionSizing = document.getElementById('position-sizing');

if (test) {
    ReactDOM.createRoot(test).render(<Test />);
}
if (positionSizing) {
    ReactDOM.createRoot(positionSizing).render(<PositionSizing />);
}
