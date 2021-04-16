function asyncTimeout(delay) {
    return (new Promise(resolve => { setTimeout(() => resolve(delay), delay) }))
        .then(d => `Waited ${d} seconds`);
}

function asyncFetch(url) {
    return fetch(url)
        .then(response => (response.text()))
        .then(text => `Fetched ${url}, and got back ${text}`);
}

function asyncFail(url) {
    return fetch(url)
        .then(response => `Fetched ${url}, and got back ${response.status}`)
        .catch((error) => {
            console.error(`asyncFail catch: `, error);
            return;
        });
}

function runTask(spec) {
    switch (spec.task) {
        case 'wait':
            return asyncTimeout(spec.duration)
        case 'fetch':
            return asyncFetch(spec.url);
        default:
            return asyncFail(spec.url);
    };
}

function getTaskList() {
    return [
        { task: 'wait', duration: 1000 },
        { task: 'fetch', url: 'https://httpstat.us/200' },
        { task: 'fetch', url: 'https://httpstat.us/404' },
        { task: 'wait', duration: 2000 },
        { task: 'fetch', url: 'https://httpstat.us/500' },
    ];
}

async function doTasksParallel() {
    const asyncThingsToDo = getTaskList();
    const tasks = asyncThingsToDo.map(runTask);
    const results = await Promise.all(tasks);
    console.time('PARALLELTIME');
    results.forEach(x => {
        console.log('PARALLEL: ' + JSON.stringify(x))
    });
    console.timeEnd('PARALLELTIME');
    return results;
}

async function doTasksSettled() {
    const asyncThingsToDo = getTaskList();
    const tasks = asyncThingsToDo.map(runTask);
    console.time('SETTLEDTIME');
    const results = await Promise.allSettled(tasks);
    results.forEach(x => {
        console.log('SETTLED: ' + JSON.stringify(x))
    });
    console.timeEnd('SETTLEDTIME');
    return results;
}

async function doTasksSequential() {
    const asyncThingsToDo = getTaskList();
    const starterPromise = Promise.resolve(null);
    const log = result => {
        console.log('SEQUENTIAL: ' + JSON.stringify(result))
    };
    console.time('SEQUENTIALTIME');
    await asyncThingsToDo.reduce(
        (p, spec) => p.then(() => runTask(spec).then(log)),
        starterPromise
    );
    console.timeEnd('SEQUENTIALTIME');
}