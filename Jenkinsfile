// vi:syntax=groovy
node {
    checkout scm

    stages {
        stage("build") {
            // Run `composer update` as a shell script
            sh 'composer install'
        }

        stage("test") {
            steps {
                // Run PHPUnit
                sh 'vendor/bin/phpunit --configuration phpunit.xml.dist'

                // Run PHPCS
                sh 'vendor/bin/phpcs -n --standard=PSR2 src'

                // If this is the master or develop branch being built then run
                // some additional integration tests
                if (["master", "staging"].contains(env.BRANCH_NAME)) {
                    // Run behat
                    sh 'vendor/bin/behat'
                }

                publishHTML([
                    allowMissing: false,
                    alwaysLinkToLastBuild: false,
                    keepAll: false,
                    reportDir: 'build/coverage',
                    reportFiles: 'index.html',
                    reportName: 'Code Coverage'
                ])
            }
        }


        if (["master", "staging"].contains(env.BRANCH_NAME)) {
            stage("upload artifacts") {
                sh "/var/lib/jenkins/.local/bin/aws deploy push --application-name JenkinsDemo --s3-location s3://delvia-jenkins-build-artifacts/${env.BRANCH_NAME}/build-${env.BUILD_NUMBER}.zip"
            }
        }

        if (env.BRANCH_NAME == 'staging') {
            stage("deploy") {
                sh "/var/lib/jenkins/.local/bin/aws deploy create-deployment --application-name JenkinsDemo --s3-location bucket=delvia-jenkins-build-artifacts,key=${env.BRANCH_NAME}/build-${env.BUILD_NUMBER}.zip,bundleType=zip --deployment-group-name Staging"

            }
        }
    }
}
