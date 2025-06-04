import React from 'react';
import styles from "./ImageTitle.module.scss";

const ImageTitle = ({ title }) => {
    return (
        <div className={styles.imageTitle}>
            <h2>{title}</h2>
        </div>
    );
};

export default ImageTitle;