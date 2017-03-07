node {
    checkout scm

    stage("composer_install") {
        // Run `composer update` as a shell script
        sh 'composer install'
    }

    stage("phpunit") {
        // Run PHPUnit
        sh 'vendor/bin/phpunit --configuration phpunit.xml.dist'
    }

    stage("php_code_sniffer") {
        // Run PHPCS
        sh 'vendor/bin/phpcs -n --standard=PSR2 src'
    }

    // If this is the master or develop branch being built then run
    // some additional integration tests
    if (["master", "staging"].contains(env.BRANCH_NAME)) {
        stage("integration_tests") {
            sh 'vendor/bin/behat'
        }

        stage("artifact_s3") {
            sh "/var/lib/jenkins/.local/bin/aws deploy push --application-name JenkinsDemo --s3-location s3://delvia-jenkins-build-artifacts/${env.BRANCH_NAME}/build-${env.BUILD_NUMBER}.zip"
        }
    }

    if (env.BRANCH_NAME == 'staging') {
        stage("deploy_staging") {
            sh "/var/lib/jenkins/.local/bin/aws deploy create-deployment --application-name JenkinsDemo --s3-location bucket=delvia-jenkins-build-artifacts,key=${env.BRANCH_NAME}/build-${env.BUILD_NUMBER}.zip,bundleType=zip --deployment-group-name Staging"

        }
    }

    stage("phpunit code coverage") {
        publishHTML([allowMissing: false, alwaysLinkToLastBuild: false, keepAll: false, reportDir: 'build/coverage', reportFiles: 'index.html', reportName: 'Code Coverage'])

        step([$class: 'CloverPublisher', cloverReportFileName: 'clover.xml', failingTarget: [], healthyTarget: [conditionalCoverage: 80, methodCoverage: 70, statementCoverage: 80], unhealthyTarget: []])

    }

}
