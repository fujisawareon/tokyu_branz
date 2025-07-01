export async function sendCreateLog(csrfToken, buildingId, viewName, binderId) {
    // 画面初期表示時にAPIリクエストを送信
    try {
        const response = await fetch(`/contents/customer/log_create/${buildingId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json",
            },
            body: JSON.stringify({
                page_key: viewName,
                binder_id: binderId,
                timestamp: new Date().toISOString(),
            }),
        });

        if (!response.ok) {
            throw new Error("ログ送信に失敗しました");
        }

        return await response.json();
    } catch (error) {
        console.error("ログ送信エラー:", error);
        return null;
    }
}
