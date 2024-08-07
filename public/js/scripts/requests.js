import utils from "./utils.js";

function ___InitializeRequests () {
    const { disableLogs } = utils.___GetSiteConfigs();
    
    if (!disableLogs) console.log('---------------=====:: Firing requests');
};

class Requester {
    #xml;

    constructor() {
        this.#xml = new XMLHttpRequest();
    }

    #SetHeaders (headers) {
        headers.forEach(({ key, value }) => {
            this.#xml.setRequestHeader(key, value);
        });
    };

    async GET (URL, query, callback) {
        const queryString = (query === null) ? '' : Object.keys(query).map(key => `${key}=${query[key]}`).join('&');

        this.#xml.open("GET", `${URL}${queryString === '' ? '' : `?${queryString}`}`);

        this.#xml.onload = function() {
            let data = JSON.parse(this.responseText);

            callback({ data });
        };

        this.#xml.send(); 
    }

    async DELETE (URL, payload, callback, options={}) {
        this.#xml.open("DELETE", URL, true);

        const {
            headers=[
                { key: 'Content-Type', value: 'application/json' }
            ]
        } = options;

        this.#SetHeaders(headers);

        this.#xml.onload = function() {
            var data = JSON.parse(this.responseText);

            callback({ data });
        };

        this.#xml.send(JSON.stringify(payload)); 
    }

    async POST (URL, payload, callback, options={}) {
        this.#xml.open("POST", URL, true);

        const {
            headers=[
                { key: 'Content-Type', value: 'application/json' }
            ]
        } = options;

        this.#SetHeaders(headers);

        this.#xml.onload = function() {
            var data = JSON.parse(this.responseText);

            callback({ data });
        };

        this.#xml.send(JSON.stringify(payload)); 
    }
};

class PlansAPI {
    #URL;

    constructor () {
        this.#URL='https://you_request_URL';
    }

    async CreatePlan (payload, callback) {
        try {
            await new Requester().POST(this.#URL, { ...payload }, callback);
        } catch (error) {
            callback({ error: new Error(error.message) });
        }
    };
};

class SignaturesAPI {
    #URL;

    constructor () {
        this.#URL='https://you_request_URL';
    }

    async GetSignatures (callback) {
        try {
            await new Requester().GET(this.#URL, null, callback);
        } catch (error) {
            callback({ error: new Error(error.message) });
        }
    };

    async GetSignature (id, callback) {
        try {
            await new Requester().GET(this.#URL, { id }, callback);
        } catch (error) {
            callback({ error: new Error(error.message) });
        }
    };

    async ConfirmPayment (payload, callback) {
        try {
            await new Requester().POST(this.#URL, { ...payload }, callback);
        } catch (error) {
            callback({ error: new Error(error.message) });
        }
    };
};

class UsersAPI {
    #URL;

    constructor () {
        this.#URL='https://you_request_URL';
    }

    async AcceptProducerRequest (id, callback) {
        try {
            await new Requester().POST(this.#URL, { id }, callback);
        } catch (error) {
            callback({ error: new Error(error.message) });
        }
    };
    
    async DeleteMember (id, callback) {
        try {
            await new Requester().DELETE(this.#URL, { id }, callback);
        } catch (error) {
            callback({ error: new Error(error.message) });
        }
    };

    async DeleteProducer (id, callback) {
        try {
            await new Requester().DELETE(this.#URL, { id }, callback);
        } catch (error) {
            callback({ error: new Error(error.message) });
        }
    };
    
    async DenyProducerRequest (id, callback) {
        try {
            await new Requester().POST(this.#URL, { id }, callback);
        } catch (error) {
            callback({ error: new Error(error.message) });
        }
    };

    async RemoveProducer (id, callback) {
        try {
            await new Requester().POST(this.#URL, { id }, callback);
        } catch (error) {
            callback({ error: new Error(error.message) });
        }
    };

    async GetProducer (id, callback) {
        try {
            await new Requester().GET(this.#URL, { id }, callback);
        } catch (error) {
            callback({ error: new Error(error.message) });
        }
    };

    async GetProducers (callback) {
        try {
            await new Requester().GET(this.#URL, null, callback);
        } catch (error) {
            callback({ error: new Error(error.message) });
        }
    };

    async GetProducerRequests (callback) {
        try {
            await new Requester().GET(this.#URL, null, callback);
        } catch (error) {
            callback({ error: new Error(error.message) });
        }
    };
};

const requests = {
    ___InitializeRequests,
    Requester,
    PlansAPI,
    SignaturesAPI,
    UsersAPI
};

export default requests;