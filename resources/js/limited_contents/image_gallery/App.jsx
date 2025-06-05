import React, { useState } from 'react';
import {createRoot} from 'react-dom/client';
import ThumbnailList from './components/ThumbnailList';
import ImageViewer from './components/ImageViewer';
import ImageTitle from './components/ImageTitle';
import MessageModal from '../MessageModal';

const rootElement = document.getElementById('react_root');

// Laravelから渡されたデータ
const contentsData = rootElement ? JSON.parse(rootElement.dataset.contents) : [];
const imageGalleryList = contentsData["image_gallery"];

const buildingId = rootElement ? JSON.parse(rootElement.dataset.building_id) : [];

const App = () => {
    const [currentIndex, setCurrentIndex] = useState(0);
    const currentImage = imageGalleryList[currentIndex];

    return (
        <div style={{ position: 'relative', height: '100%', overflow: 'hidden'}}>
            {contentsData["image_gallery_annotation"] &&
                <MessageModal message={contentsData["image_gallery_annotation"]} />
            }

            <ImageViewer
                buildingId={buildingId}
                image={currentImage}
                onNext={() => setCurrentIndex((currentIndex + 1) % imageGalleryList.length)}
                onPrev={() => setCurrentIndex((currentIndex - 1 + imageGalleryList.length) % imageGalleryList.length)}
            />
            <ImageTitle title={currentImage.title} />
            <ThumbnailList
                buildingId={buildingId}
                images={imageGalleryList}
                activeIndex={currentIndex}
                onSelect={(index) => setCurrentIndex(index)}
            />
        </div>
    );
};

if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<App />);
}