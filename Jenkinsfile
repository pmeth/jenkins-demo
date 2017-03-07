// vi:syntax=groovy
pipeline {
    agent any

    stages {
        stage("build") {
            steps {
                // Run `composer update` as a shell script
                sh 'composer install'


            when { ["master", "staging"].contains(env.BRANCH_NAME) }
            {
                sh "/var/lib/jenkins/.local/bin/aws deploy push --application-name JenkinsDemo --s3-location s3://delvia-jenkins-build-artifacts/${env.BRANCH_NAME}/build-${env.BUILD_NUMBER}.zip"
            }
        }

        stage("test") {
            steps {
                // Run PHPUnit
                sh 'vendor/bin/phpunit --configuration phpunit.xml.dist'

                // Run PHPCS
                sh 'vendor/bin/phpcs -n --standard=PSR2 src'

                // If this is the master or develop branch being built then run
                // some additional integration tests
                when { ["master", "staging"].contains(env.BRANCH_NAME) }
                {
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

        stage("deploy") {
            when { env.BRANCH_NAME == 'staging' && currentBuild.result == 'SUCCESS' }
            steps {
                sh "/var/lib/jenkins/.local/bin/aws deploy create-deployment --application-name JenkinsDemo --s3-location bucket=delvia-jenkins-build-artifacts,key=${env.BRANCH_NAME}/build-${env.BUILD_NUMBER}.zip,bundleType=zip --deployment-group-name Staging"

            }
        }
    }
}
