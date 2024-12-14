module.exports = {
    apps: [
        {
            name: 'tz-startups-stage',
            port: '1335',
            exec_mode: 'cluster',
            instances: 'max',
            script: './.output/server/index.mjs'
        }
    ]
}
