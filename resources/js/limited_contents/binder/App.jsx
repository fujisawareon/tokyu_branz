import React, {useState, useEffect} from 'react';
import {motion, AnimatePresence} from 'framer-motion';
import {createRoot} from "react-dom/client";
import PDFViewer from './components/PDFViewer';
import PDFBinder from './components/PDFBinder';
import URLBinder from './components/URLBinder';
import {sendCreateLog} from './utils/logging';
import {Log} from '../Log.js'; // パスはプロジェクト構成に応じて

function MainContents({contentsData}) {
    const [selectedBinder, setSelectedBinder] = useState(null);
    const [openCategories, setOpenCategories] = useState({});
    const allOpen = Object.values(openCategories).every(Boolean);
    const [appLogId, setAppLogId] = useState(null);

    const buildingId = window.buildingId;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    useEffect(() => {
        sendCreateLog(csrfToken, buildingId, "building_documents").then((data) => {
            if (data) {
                setAppLogId(data.app_log_id); // 必要であれば
            }
        });
    }, []);

    // 初期マウント時に全て true に設定
    useEffect(() => {
        const initialOpen = {};
        contentsData.category.forEach((cat) => {
            initialOpen[cat.id] = true;
        });
        setOpenCategories(initialOpen);
    }, [contentsData]);

    const toggleCategory = (id) => {
        setOpenCategories((prev) => ({
            ...prev,
            [id]: !prev[id]
        }));
    };
    const toggleAll = () => {
        const allIds = contentsData.category.map((c) => c.id);
        const newState = {};
        allIds.forEach((id) => {
            newState[id] = !allOpen;
        });
        setOpenCategories(newState);
    };

    if (selectedBinder) {
        return <PDFViewer
            binder={selectedBinder}
            onBack={() => {
                Log.updateStayTime(csrfToken, buildingId, appLogId);
                setSelectedBinder(null);
                sendCreateLog(csrfToken, buildingId, "building_documents").then((data) => {
                    if (data) {
                        setAppLogId(data.app_log_id); // 必要であれば
                    }
                });
            }}
        />;
    }

    return (
        <div className="main-contents">
            <div className="p-4">
                {/* 一括開閉ボタン */}
                <div className="flex justify-end mb-2">
                    <button
                        className="px-4 py-1 rounded"
                        onClick={toggleAll}
                    >
                        {allOpen ? "全て閉じる ▲" : "全て開く ▼"}
                    </button>
                </div>

                {contentsData.category.map((category) => (
                    <div key={category.id}>
                        <div
                            className="mt-2 cursor-pointer bg-gray-300 p-2 font-bold flex justify-between items-center"
                            onClick={() => toggleCategory(category.id)}
                            style={{backgroundColor: "#0c4a6e", color: "#fff", padding: "0.5rem"}}
                        >
                            <span>{category.category_name}</span>
                            <span>{openCategories[category.id] ? "▲" : "▼"}</span>
                        </div>

                        {/* 開いている場合のみ表示 */}
                        <AnimatePresence initial={false}>
                            {openCategories[category.id] && (
                                <motion.div
                                    key={category.id}
                                    className="mb-4 p-2 flex flex-row flex-wrap gap-2"
                                    initial={{height: 0, opacity: 0}}
                                    animate={{height: "auto", opacity: 1}}
                                    exit={{height: 0, opacity: 0}}
                                    transition={{duration: 0.3}}
                                    style={{overflow: "hidden"}}
                                >
                                    {category.binder_building.map((binder) => (
                                        <div
                                            key={binder.id}
                                            style={{border: "solid 1px #aaa"}}
                                        >
                                            {binder.binder_type === 0 ? (
                                                <PDFBinder
                                                    binder={binder}
                                                    onSelect={() => {
                                                        setSelectedBinder(binder);
                                                        Log.updateStayTime(csrfToken, buildingId, appLogId);
                                                        sendCreateLog(csrfToken, buildingId, "building_documents", binder.id).then((data) => {
                                                            if (data) setAppLogId(data.app_log_id); // 必要であれば
                                                        });
                                                    }}
                                                />
                                            ) : (
                                                <URLBinder binder={binder}/>
                                            )}
                                        </div>
                                    ))}
                                </motion.div>
                            )}
                        </AnimatePresence>
                    </div>
                ))}
            </div>
        </div>
    );
}

const rootElement = document.getElementById("react_root");
if (rootElement) {
    const contentsData = JSON.parse(rootElement.dataset.contents || "{}");
    const root = createRoot(rootElement);
    root.render(<MainContents contentsData={contentsData}/>);
}