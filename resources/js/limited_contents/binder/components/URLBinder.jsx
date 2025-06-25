import React from "react";

export default function URLBinder({ binder }) {
    return (
        <div>
            <div className="cursor-pointer">
                <a
                    href={binder.url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="cursor-pointer"
                >
                    <img
                        src="/svg/browser_window_ui.svg"
                        alt={binder.binder_name}
                        style={{width: "300px", height: "150px", objectFit: "cover"}}
                    />
                </a>
            </div>
            <div className="p-2">{binder.binder_name}</div>
        </div>
    );
}