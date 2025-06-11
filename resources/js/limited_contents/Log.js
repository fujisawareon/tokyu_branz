
export class Log {

    static updateStayTime(csrfToken, buildingId, appLogId) {
        if(appLogId === null){
            return;
        }
        //ログ送信
        fetch(`/contents/customer/log_update_stay_time/${buildingId}/${appLogId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
        })
            .then(response => {
                if (response.status === 404) {
                    throw new Error('⚠️ ログ送信先のエンドポイントが見つかりませんでした (404)');
                }
                if (response.headers.get("content-type")?.includes("application/json")) {
                    return response.json();
                }
                return response.text(); // fallback
            })
            .then(data => {
                 // 成功時は処理は行なわない
            })
            .catch(error =>
                alert(error)
            );


    }

}

