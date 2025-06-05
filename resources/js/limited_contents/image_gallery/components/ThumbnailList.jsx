import React, { useState } from 'react';
import s from './ThumbnailList.module.scss';
const ThumbnailList = ({ buildingId, images, onSelect, activeIndex }) => {
    const [showList, setShowList] = useState(true);

    return (
        <div className={`${s.thumbnailWrapper} ${showList ? s.show : ''}`}>
            <button
                className={s.toggleButton}
                onClick={() => setShowList(!showList)}
            >
                {showList ? '▽' : '△'}
            </button>

            <div className={s.thumbnailList}>
                {images.map((image, index) => (
                    <div
                        key={image.id}
                        className={`${s.thumbnailItem} ${index === activeIndex ? s.isActive : ''}`}
                        onClick={() => onSelect(index)}
                    >
                        <img
                            src={`/storage/${buildingId}/image_gallery/thumbnail/${image.image_file_name}`}
                            alt={image.title}
                            className={s.thumbnailImage}
                        />
                        <div className={s.caption}>{image.title}</div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default ThumbnailList;

