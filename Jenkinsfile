node {
    stage('preparation') {
        git url: 'https://github.com/pmeth/jenkins-demo.git'
    }

    stage("composer_install") {
        // Run `composer update` as a shell script
        sh 'composer install'
    }

    stage("phpunit") {
        // Run PHPUnit
        sh 'vendor/bin/phpunit'
    }

    // If this is the master or develop branch being built then run
    // some additional integration tests
    if (["master", "staging"].contains(env.BRANCH_NAME)) {
        stage("integration_tests") {
            sh 'vendor/bin/behat'
        }

        stage("artifact_s3") {
            sh "/var/lib/jenkins/.local/bin/aws deploy push --application-name JenkinsDemo --s3-location s3://delvia-jenkins-build-artifacts/build-${env.BUILD_NUMBER}.zip"
        }
    }

    if (env.BRANCH_NAME == 'staging') {
        stage("deploy_staging") {
            sh "/var/lib/jenkins/.local/bin/aws deploy create-deployment --application-name JenkinsDemo --s3-location bucket=delvia-jenkins-build-artifacts,key=build-${env.BUILD_NUMBER}.zip,bundleType=zip --deployment-group-name Staging"

        }
    }

}
