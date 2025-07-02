import React from 'react';
import styles from './ImageViewer.module.scss';

const ImageViewer = ({ buildingId, image, onPrev, onNext, imagesCount }) => {
    return (
        <div className={styles.imageViewer}>
            {imagesCount > 1 && (
                <div className={`${styles.navigation} ${styles.left}`} onClick={onPrev}>
                    ‹
                </div>
            )}

            <img
                src={`/storage/${buildingId}/image_gallery/${image.image_file_name}`}
                alt={image.title}
                className={styles.mainImage}
            />

            {imagesCount > 1 && (
                <div className={`${styles.navigation} ${styles.right}`} onClick={onNext}>
                    ›
                </div>
            )}
        </div>
    );
};

export default ImageViewer;