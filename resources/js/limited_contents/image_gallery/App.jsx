import React, { useState } from 'react';
import {createRoot} from 'react-dom/client';
import ThumbnailList from './components/ThumbnailList';
import ImageViewer from './components/ImageViewer';
import ImageTitle from './components/ImageTitle';

const rootElement = document.getElementById('react_root');

// Laravelから渡されたデータ
const contentsData = rootElement ? JSON.parse(rootElement.dataset.contents) : [];
const buildingId = rootElement ? JSON.parse(rootElement.dataset.building_id) : [];

const App = () => {
    const [currentIndex, setCurrentIndex] = useState(0);
    const currentImage = contentsData[currentIndex];

    return (
        <div style={{position: 'relative', height: '100%'}}>
            <ImageViewer
                buildingId={buildingId}
                image={currentImage}
                onNext={() => setCurrentIndex((currentIndex + 1) % contentsData.length)}
                onPrev={() => setCurrentIndex((currentIndex - 1 + contentsData.length) % contentsData.length)}
            />
            <ImageTitle title={currentImage.title} />
            <ThumbnailList
                buildingId={buildingId}
                images={contentsData}
                onSelect={(index) => setCurrentIndex(index)}
            />
        </div>
    );
};

if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<App />);
}