import utils from "./utils.js";

function ___InitializeRequests () {
    const { disableLogs } = utils.___GetSiteConfigs();

    if (!disableLogs) console.log('---------------=====:: Firing requests');
};

const requests = {
    ___InitializeRequests
};

export default requests;
