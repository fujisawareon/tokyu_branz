import React from 'react';
import styles from './ThumbnailList.module.scss';

const ThumbnailList = ({ buildingId, images, onSelect }) => {
    return (
        <div className={styles.thumbnailList}>
            {images.map((image, index) => (
                <div
                    key={image.id}
                    className={styles.thumbnailItem}
                    onClick={() => onSelect(index)}
                >
                    <img
                        src={`/storage/${buildingId}/image_gallery/thumbnail/${image.image_file_name}`}
                        alt={image.title}
                        className={styles.thumbnailImage}
                    />
                    <div className={styles.caption}>{image.title}</div>
                </div>
            ))}
        </div>
    );
};

export default ThumbnailList;