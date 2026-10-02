from flask import Flask, Response, request, redirect
import requests

app = Flask(__name__)

@app.route('/', defaults={'path': ''})
@app.route('/<path:path>')
def proxy(path):
    stream_id = request.args.get('stream_id', '34747')
    
    # നിങ്ങൾ ആവശ്യപ്പെട്ട കൃത്യമായ ലിങ്ക് ഫോർമാറ്റ്
    target_url = f"http://raztv.online//live/MAGNL39E26/hvhS6xsuZP/{stream_id}.m3u8?token=stream"
    
    headers = {
        'User-Agent': 'Mozilla/5.0 (Linux; Android 10) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.120 Mobile Safari/537.36',
        'Accept': '*/*'
    }
    
    try:
        resp = requests.get(target_url, headers=headers, stream=True, timeout=10)
        excluded_headers = ['content-encoding', 'content-length', 'transfer-encoding', 'connection']
        resp_headers = [(name, value) for name, value in resp.headers.items() if name.lower() not in excluded_headers]
        
        return Response(resp.raw.read(), status=resp.status_code, headers=resp_headers)
    except Exception as e:
        # ഫെച്ച് ചെയ്യാൻ പറ്റിയില്ലെങ്കിൽ ഡയറക്റ്റ് റീഡയറക്ട് ചെയ്യും
        return redirect(target_url, code=302)

if __name__ == '__main__':
    app.run()
