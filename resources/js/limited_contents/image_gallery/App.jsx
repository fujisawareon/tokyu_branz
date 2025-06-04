import React, { useState } from 'react';
import {createRoot} from 'react-dom/client';
import ThumbnailList from './components/ThumbnailList';
import ImageViewer from './components/ImageViewer';
import ImageTitle from './components/ImageTitle';
import MessageModal from '../MessageModal';

const rootElement = document.getElementById('react_root');

// Laravelから渡されたデータ
const contentsData = rootElement ? JSON.parse(rootElement.dataset.contents) : [];
const imageGallery = contentsData["image_gallery"];

const buildingId = rootElement ? JSON.parse(rootElement.dataset.building_id) : [];

const App = () => {
    const [currentIndex, setCurrentIndex] = useState(0);
    const currentImage = imageGallery[currentIndex];

    return (
        <div style={{ position: 'relative', height: '100%' }}>
            {contentsData["image_gallery_annotation"] &&
                <MessageModal message={contentsData["image_gallery_annotation"]} />
            }

            <ImageViewer
                buildingId={buildingId}
                image={currentImage}
                onNext={() => setCurrentIndex((currentIndex + 1) % imageGallery.length)}
                onPrev={() => setCurrentIndex((currentIndex - 1 + imageGallery.length) % imageGallery.length)}
            />
            <ImageTitle title={currentImage.title} />
            <ThumbnailList
                buildingId={buildingId}
                images={imageGallery}
                onSelect={(index) => setCurrentIndex(index)}
            />
        </div>
    );
};

if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<App />);
}