import React from "react";
import URLBinder from "./URLBinder.jsx";

export default function PDFBinder({ binder, onSelect }) {

    const presentation_mode = window.presentation_mode;
    return (
        <div>
            <div className="cursor-pointer" onClick={onSelect}>
                <img
                    src={`/storage/${binder.thumbnail_file_path}`}
                    alt={binder.binder_name}
                    style={{width: "300px", height: "150px", objectFit: "cover"}}
                />
            </div>

            <div className="flex justify-between items-center">
                <div className="p-2">{binder.binder_name}</div>
                {window.presentation_mode && (
                    <div className="">
                        <a href="">
                            <img
                                src="/svg/open_in_new_tab.svg"
                                style={{width: "30px", height: "30px", objectFit: "cover"}}
                            />
                        </a>
                    </div>
                )}
            </div>
        </div>
    );
}