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
    }

    // Create new deployment assets
    switch (env.BRANCH_NAME) {
        case "master":
            stage("codedeploy") {
                sh "aws deploy push --application-name Jenkins_Demo_Production --s3-location s3://delvia-jenkins-build-artifacts/production/build-${env.BUILD_NUMBER}.zip"
            }
            break
        case "staging":
            stage("codedeploy") {
                sh "aws deploy push --application-name Jenkins_Demo_Staging --s3-location s3://delvia-jenkins-build-artifacts/staging/build-${env.BUILD_NUMBER}.zip"
            }
            break
        default:
            // No deployments for other branches
            break
    }

}
