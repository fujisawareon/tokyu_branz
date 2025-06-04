import React from 'react';
import styles from './ImageViewer.module.scss';

const ImageViewer = ({ buildingId, image, onPrev, onNext }) => {
    return (
        <div className={styles.imageViewer}>
            <div className={`${styles.navigation} ${styles.left}`} onClick={onPrev}>
                ‹
            </div>

            <img
                src={`/storage/${buildingId}/image_gallery/${image.image_file_name}`}
                alt={image.title}
                className={styles.mainImage}
            />

            <div className={`${styles.navigation} ${styles.right}`} onClick={onNext}>
                ›
            </div>
        </div>
    );
};

export default ImageViewer;