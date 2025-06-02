import React from 'react';
import {createRoot} from 'react-dom/client';
import Example from './Example';

const rootElement = document.getElementById('react-root');

console.log(rootElement)
if (rootElement) {
    const userName = rootElement.dataset.userName;

    const root = createRoot(rootElement);
    root.render(<Example userName={userName} />);
}
