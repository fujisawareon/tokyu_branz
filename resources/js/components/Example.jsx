import React from 'react';


export default function Example({ users }) {
    return (
        <div>
            <h2>ユーザー一覧</h2>
            <ul>
                {users.map(user => (
                    <li key={user.id}>
                        {user.name}（{user.email}）
                    </li>
                ))}
            </ul>
        </div>
    );
}
