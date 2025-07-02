import React, { useState, useMemo } from 'react';
import { createRoot } from 'react-dom/client';
import ThumbnailList from './components/ThumbnailList';
import ImageViewer from './components/ImageViewer';
import ImageTitle from './components/ImageTitle';
import MessageModal from '../MessageModal';

const rootElement = document.getElementById('react_root');

// Laravelから渡されたデータをパース
const contentsData = rootElement ? JSON.parse(rootElement.dataset.contents) : {};
const imageGalleryList = contentsData.image_gallery || [];
const imageGalleryAnnotation = contentsData.image_gallery_annotation || '';

const buildingId = window.buildingId;

const App = () => {
    const [currentIndex, setCurrentIndex] = useState(0);

    // 現在の画像をメモ化
    const currentImage = useMemo(() => imageGalleryList[currentIndex] || {}, [imageGalleryList, currentIndex]);
    const hasImages = imageGalleryList.length > 0;

    const handleNext = () => {
        setCurrentIndex((prevIndex) => (prevIndex + 1) % imageGalleryList.length);
    };

    const handlePrev = () => {
        setCurrentIndex((prevIndex) => (prevIndex - 1 + imageGalleryList.length) % imageGalleryList.length);
    };

    const handleSelect = (index) => {
        setCurrentIndex(index);
    };

    if (!hasImages) {
        return (
            <>
                {imageGalleryAnnotation && <MessageModal message={imageGalleryAnnotation} />}
                <div style={{ textAlign: 'center', fontSize: '1.5rem', padding: '2rem' }}>
                    画像がありません。
                </div>
            </>
        );
    }

    return (
        <div style={{ position: 'relative', height: '100%', overflow: 'hidden' }}>
            {imageGalleryAnnotation && <MessageModal message={imageGalleryAnnotation} />}

            <ImageViewer
                buildingId={buildingId}
                image={currentImage}
                onNext={handleNext}
                onPrev={handlePrev}
                imagesCount={imageGalleryList.length}
            />
            <ImageTitle title={currentImage.title} />
            <ThumbnailList
                buildingId={buildingId}
                images={imageGalleryList}
                activeIndex={currentIndex}
                onSelect={handleSelect}
            />
        </div>
    );
};

if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<App />);
}
