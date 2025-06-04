import React, { useState } from 'react';
import styles from "./MessageModal.module.scss";

const AnnotationModal = ({ message }) => {
    const [visible, setVisible] = useState(true);
    const [closing, setClosing] = useState(false);

    const handleClose = () => {
        setClosing(true);
        setTimeout(() => setVisible(false), 200); // アニメーション後に非表示
    };

    if (!visible) return null;

    return (
        <div className={`${styles.modalOverlay} ${closing ? styles.modalClosing : ''}`}>
            <div dangerouslySetInnerHTML={{ __html: message.replace(/\n/g, '<br />') }} />

            <div className={styles.closeButton} onClick={handleClose}>
                閉じる
            </div>
        </div>
    );
};

export default AnnotationModal;