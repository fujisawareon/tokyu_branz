import React from 'react';
import {createRoot} from 'react-dom/client';
import Example from '../components/Example';

const rootElement = document.getElementById('react-root');

if (rootElement) {
    const userName = rootElement.dataset.userName;
    const person_charge = rootElement.dataset.personCharge;

    const users = JSON.parse(rootElement.dataset.users); // JSON 文字列をオブジェクトに変換

    const root = createRoot(rootElement);
    root.render(<Example users={users} />);
}
