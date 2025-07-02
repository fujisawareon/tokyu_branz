import React, { useState, useRef, useEffect } from 'react';
import s from './ThumbnailList.module.scss';
const ThumbnailList = ({ buildingId, images, onSelect, activeIndex }) => {
    const [showList, setShowList] = useState(true);
    const itemRefs = useRef([]);

    useEffect(() => {
        if (itemRefs.current[activeIndex]) {
            itemRefs.current[activeIndex].scrollIntoView({
                behavior: 'smooth',
                inline: 'center',
                block: 'nearest',
            });
        }
    }, [activeIndex]);

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
                        ref={el => itemRefs.current[index] = el}
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

