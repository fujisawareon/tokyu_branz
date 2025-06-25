import React from "react";
import styles from './PDFViewer.module.scss';

export default function PDFViewer({ binder, onBack }) {
    return (
        <div className="">
            <div className={styles.binderNavigation}>
                <button className="btn" onClick={onBack}>戻る</button>
                <h2>{binder.binder_name}</h2>
                {window.presentation_mode && (
                    <a href="" className="flex items-center">
                        別タブで開く
                        <img
                            src="/svg/open_in_new_tab.svg"
                            style={{width: "30px", height: "30px", objectFit: "cover"}}
                        />
                    </a>
                )}
            </div>
            <div className="p-2">
                {binder.file_path && (
                    <iframe
                        src={`/pdfjs/web/viewer.html?file=/storage/${binder.file_path}&disablePrint=true&disableDownload=true`}
                        id="frame-area"
                        width="100%"
                        height="700"
                        title={binder.binder_name}
                    ></iframe>
                )}
            </div>
        </div>
    );
}
